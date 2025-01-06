<?php

namespace App\Filament\Resources\PengadaanResource;

use Filament\Forms;
use App\Models\Obat;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Pengadaan;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PengadaanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PengadaanResource\RelationManagers;

class PengadaanResource extends Resource
{
    protected static ?string $model = Pengadaan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Utama')
                    ->description('Isi terleih dahulu bagian berikut ini')
                    ->schema([
                        Forms\Components\Select::make('supplier_id')
                            ->relationship(name: 'supplier', titleAttribute: 'nama_supplier')
                            ->native(false)
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('nota_pengadaan')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('tanggal')
                            ->required(),
                    ])->columns(2),

                Section::make('Detail Obat')
                    ->description('Isikan detail obat yang ada disini')
                    ->schema([
                        Repeater::make('details')
                            ->relationship(name: 'details')
                            ->schema([
                                Forms\Components\Select::make('obat_id')
                                    ->options(Obat::all()->pluck('nama_obat', 'id'))
                                    ->label('Pilih Obat')
                                    ->preload()
                                    ->native(false)
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $obat = Obat::find($get('obat_id'));
                                        $set('harga', $obat->harga_beli);
                                        $set('harga', $obat->harga_beli);
                                    }),
                                Forms\Components\TextInput::make('satuan')
                                    ->required(),
                                Forms\Components\TextInput::make('harga')
                                    ->numeric()
                                    ->readOnly()
                                    ->prefix("Rp.")
                                    ->required(),
                                Forms\Components\TextInput::make('jumlah')
                                    ->numeric()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $set('subtotal', $get('jumlah') * $get('harga'));
                                    }),
                                Forms\Components\TextInput::make('subtotal')
                                    ->numeric()
                                    ->readOnly()
                                    ->prefix("Rp.")
                                    ->required(),

                            ])->columns(2)
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::updateRepeater($get, $set);
                            })
                    ]),

                Section::make('Lain Lain')
                    ->schema([
                        Forms\Components\TextInput::make('total')
                            ->readOnly()
                            ->prefix('Rp.')
                            ->required()
                            ->numeric(),
                        Forms\Components\Textarea::make('keterangan')
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('supplier_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nota_pengadaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengadaans::route('/'),
            'create' => Pages\CreatePengadaan::route('/create'),
            'edit' => Pages\EditPengadaan::route('/{record}/edit'),
        ];
    }

    public static function updateRepeater(Get $get, Set $set): void
    {
        $selectedProducts = collect($get('details'))->filter(fn($item) => !empty($item['obat_id']) && !empty($item['jumlah']));

        $prices = Obat::find($selectedProducts->pluck('obat_id'))->pluck('harga_beli', 'id');

        // dd($prices);

        // Calculate subtotal based on the selected products and quantities
        $subtotal = $selectedProducts->reduce(function ($subtotal, $obat) use ($prices) {
            return $subtotal + ($prices[$obat['obat_id']] * $obat['jumlah']);
        }, 0);

        $set('total', $subtotal);
    }
}

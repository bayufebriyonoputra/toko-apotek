<?php

namespace App\Filament\Resources\PenjualanResource;

use Filament\Forms;
use App\Models\Obat;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Penjualan;
use Filament\Tables\Table;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Blade;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PenjualanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\PenjualanResource\RelationManagers;
use Filament\Notifications\Notification;

class PenjualanResource extends Resource
{
    protected static ?string $model = Penjualan::class;

    protected static ?string $navigationIcon = 'fas-cart-flatbed';
    protected static ?string $navigationLabel = 'Penjualan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Utama')
                    ->description('Isi terleih dahulu bagian berikut ini')
                    ->schema([
                        Forms\Components\Select::make('dokter_id')
                            ->relationship(name: 'dokter', titleAttribute: 'nama_dokter')
                            ->native(false)
                            ->preload(),
                        Forms\Components\TextInput::make('no_nota')
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
                                        $set('harga', $obat->harga_jual);
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
                                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                        $obat = Obat::find($get('obat_id'));
                                        if ($obat) {
                                            //cek stok
                                            if ($state > $obat->stok_obat) {
                                                $set('jumlah', null);
                                                Notification::make()
                                                    ->title('Stok Obat Tidak Cukup')
                                                    ->danger()
                                                    ->send();
                                            } else {
                                                $set('subtotal', $state * $get('harga'));
                                            }
                                        }
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
            ->headerActions([
                ExportAction::make()->label('Download Report')
                    ->icon('fas-download'),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dokter_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('no_nota')
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
                Tables\Actions\Action::make('pdf')
                    ->label('Nota')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn(Penjualan $record) => route('pdf', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make(),
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
            'index' => Pages\ListPenjualans::route('/'),
            'create' => Pages\CreatePenjualan::route('/create'),
            'edit' => Pages\EditPenjualan::route('/{record}/edit'),
        ];
    }

    public static function updateRepeater(Get $get, Set $set): void
    {
        $selectedProducts = collect($get('details'))->filter(fn($item) => !empty($item['obat_id']) && !empty($item['jumlah']));

        $prices = Obat::find($selectedProducts->pluck('obat_id'))->pluck('harga_jual', 'id');

        // dd($prices);

        // Calculate subtotal based on the selected products and quantities
        $subtotal = $selectedProducts->reduce(function ($subtotal, $obat) use ($prices) {
            return $subtotal + ($prices[$obat['obat_id']] * $obat['jumlah']);
        }, 0);

        $set('total', $subtotal);
    }
}

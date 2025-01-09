<?php

namespace App\Filament\Resources\ObatResource;

use App\Enum\RoleEnum;
use Filament\Forms;
use App\Models\Obat;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ObatResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ObatResource\RelationManagers;
use Illuminate\Database\Eloquent\Model;

class ObatResource extends Resource
{
    protected static ?string $model = Obat::class;

    protected static ?string $navigationIcon = 'fas-pills';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('kategori_id')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->relationship('kategoriObat', 'name'),
                Forms\Components\TextInput::make('nama_singkat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_obat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('indikasi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('keterangan_obat')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('stok_obat')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('kadaluarsa')
                    ->native(false)
                    ->required(),
                Forms\Components\TextInput::make('harga_beli')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('harga_jual')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kategoriObat.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_singkat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_obat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('indikasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stok_obat')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kadaluarsa')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('harga_beli')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('harga_jual')
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
                Tables\Actions\DeleteAction::make(),

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
            'index' => Pages\ListObats::route('/'),
            'create' => Pages\CreateObat::route('/create'),
            'edit' => Pages\EditObat::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        if (Auth::user()->role == RoleEnum::ADMIN) return true;
        return false;

    }

    public static function canEdit(Model $record): bool
    {
        if (Auth::user()->role == RoleEnum::ADMIN) return true;
        return false;
    }
}

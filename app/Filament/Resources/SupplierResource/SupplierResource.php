<?php

namespace App\Filament\Resources\SupplierResource;

use App\Filament\Resources\SupplierResource\Pages;
use App\Filament\Resources\SupplierResource\RelationManagers;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static ?string $navigationIcon = 'fas-boxes-packing';
    protected static ?string $navigationLabel = 'Supplier';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('kode_supplier')
                    ->label('Kode Supplier')
                    ->required(),
                TextInput::make('nama_supplier')
                    ->required(),
                Textarea::make('alamat_supplier')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
                TextInput::make('kota')
                    ->required(),
                TextInput::make('phone')
                    ->numeric()
                    ->required(),
                TextInput::make('npwp')
                    ->required(),
                TextInput::make('bank')
                    ->required(),
                TextInput::make('atas_nama')
                    ->required()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_supplier')
                    ->label('Kode Supplier')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nama_supplier')
                    ->label('Nama Supplier')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('alamat_supplier')
                    ->label('Alamat Supplier')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('kota')
                    ->label('Kota')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('npwp')
                    ->label('NPWP')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('bank')
                    ->label('Bank')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('atas_nama')
                    ->label('Atas Nama')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}

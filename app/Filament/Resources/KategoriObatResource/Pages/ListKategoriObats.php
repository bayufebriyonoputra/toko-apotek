<?php

namespace App\Filament\Resources\KategoriObatResource\Pages;


use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\KategoriObatResource\KategoriObatResource;


class ListKategoriObats extends ListRecords
{
    protected static string $resource = KategoriObatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\KategoriObatResource\Pages;


use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\KategoriObatResource\KategoriObatResource;

class EditKategoriObat extends EditRecord
{
    protected static string $resource = KategoriObatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\PengadaanResource\Pages;


use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PengadaanResource\PengadaanResource;

class ListPengadaans extends ListRecords
{
    protected static string $resource = PengadaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

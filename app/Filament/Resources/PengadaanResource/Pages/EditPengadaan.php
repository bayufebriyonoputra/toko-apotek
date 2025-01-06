<?php

namespace App\Filament\Resources\PengadaanResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\PengadaanResource\PengadaanResource;

class EditPengadaan extends EditRecord
{
    protected static string $resource = PengadaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

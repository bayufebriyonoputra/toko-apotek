<?php

namespace App\Filament\Resources\DokterResource\Pages;


use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\DokterResource\DokterResource;

class EditDokter extends EditRecord
{
    protected static string $resource = DokterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

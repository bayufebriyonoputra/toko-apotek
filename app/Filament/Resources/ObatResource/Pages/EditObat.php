<?php

namespace App\Filament\Resources\ObatResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ObatResource\ObatResource;

class EditObat extends EditRecord
{
    protected static string $resource = ObatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

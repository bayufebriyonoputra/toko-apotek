<?php

namespace App\Filament\Resources\PenjualanResource\Pages;


use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\PenjualanResource\PenjualanResource;

class EditPenjualan extends EditRecord
{
    protected static string $resource = PenjualanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

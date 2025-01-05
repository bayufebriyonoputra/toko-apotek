<?php

namespace App\Filament\Resources\ObatResource\Pages;


use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ObatResource\ObatResource;

class ListObats extends ListRecords
{
    protected static string $resource = ObatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

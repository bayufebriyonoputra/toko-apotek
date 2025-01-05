<?php

namespace App\Filament\Resources\SupplierResource\Pages;


use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\SupplierResource\SupplierResource;

class CreateSupplier extends CreateRecord
{
    protected static string $resource = SupplierResource::class;
}

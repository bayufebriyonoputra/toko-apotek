<?php

namespace App\Filament\Resources\PengadaanResource\Pages;


use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PengadaanResource\PengadaanResource;
use Illuminate\Support\Facades\Auth;

class CreatePengadaan extends CreateRecord
{
    protected static string $resource = PengadaanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;

        return $data;
    }
}

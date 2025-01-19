<?php

namespace App\Filament\Resources\PengadaanResource\Pages;


use App\Models\Obat;
use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PengadaanResource\PengadaanResource;

class CreatePengadaan extends CreateRecord
{
    protected static string $resource = PengadaanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;

        return $data;
    }

    protected function afterCreate(): void
    {
        $details = $this->data['details'] ?? [];
        foreach ($details as $detail) {
            $obat = Obat::find($detail['obat_id']);

            if ($obat) {
                $obat->stok_obat += $detail['jumlah'];
                $obat->save();
            }
        }
    }
}

<?php

namespace App\Filament\Resources\PenjualanResource\Pages;


use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PenjualanResource\PenjualanResource;
use App\Models\Dokter;
use App\Models\Obat;
use App\Models\Penjualan;

class CreatePenjualan extends CreateRecord
{
    protected static string $resource = PenjualanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;


        return $data;
    }

    protected function handleRecordCreation(array $data): Penjualan
    {
        if ($data['dokter_id']) {
            $komisi = (int) $data['total'] * 0.005;

            $dokter = Dokter::find($data['dokter_id']);
            $dokter->royalti_dokter += $komisi;
            $dokter->save();
        }
        return static::getModel()::create($data);
    }

    protected function afterCreate(): void
    {
        $details = $this->data['details'] ?? [];
        foreach ($details as $detail) {
            $obat = Obat::find($detail['obat_id']);

            if ($obat) {
                $obat->stok_obat -= $detail['jumlah'];
                $obat->save();
            }
        }
    }
}

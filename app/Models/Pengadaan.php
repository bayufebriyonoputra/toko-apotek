<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengadaan extends Model
{
    
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(PengadaanDetail::class, 'nota_pengadaan', 'nota_pengadaan');
    }
}

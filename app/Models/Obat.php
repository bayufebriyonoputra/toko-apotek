<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Obat extends Model
{
    
    public function kategoriObat(): BelongsTo
    {
        return $this->belongsTo(KategoriObat::class, 'kategori_id', 'id');
    }
}

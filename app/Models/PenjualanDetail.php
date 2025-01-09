<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenjualanDetail extends Model
{
    public function obat(): BelongsTo
    {
        return $this->belongsTo(Obat::class, 'obat_id', 'id');
    }
}

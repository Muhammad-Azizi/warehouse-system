<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangMasukDetail extends Model
{
    protected $fillable = [
        'barang_masuk_id',
        'material_id',
        'qty',
        'uom',
    ];

    public function barangMasuk(): BelongsTo
    {
        return $this->belongsTo(BarangMasuk::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
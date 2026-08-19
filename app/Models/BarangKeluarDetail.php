<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangKeluarDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_keluar_id',
        'material_id',
        'qty',
        'satuan',
    ];

    public function barangKeluar()
    {
        return $this->belongsTo(BarangKeluar::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}
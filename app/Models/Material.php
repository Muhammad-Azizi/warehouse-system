<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'material_number',
        'description',
        'qty_stock',
        'uom',
        'storage_bin',
    ];

    protected $casts = [
        'qty_stock' => 'integer',
    ];
}
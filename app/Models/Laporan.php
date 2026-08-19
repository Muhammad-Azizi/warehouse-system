<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporans';

    protected $fillable = [
        'nomor_laporan',
        'tanggal',
        'jenis_laporan',
        'keterangan',
        'total_item',
        'total_qty',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'total_qty' => 'decimal:2',
    ];
}
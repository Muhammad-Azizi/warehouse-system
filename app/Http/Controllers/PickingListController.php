<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;

class PickingListController extends Controller
{
    /**
     * Menampilkan semua transaksi barang keluar
     */
    public function index()
    {
        $barangKeluars = BarangKeluar::with('details.material')
            ->latest()
            ->get();

        return view('picking-list.index', compact('barangKeluars'));
    }

    /**
     * Menampilkan detail picking list
     */
    public function show(BarangKeluar $barangKeluar)
    {
        $barangKeluar->load('details.material');

        return view('picking-list.show', compact('barangKeluar'));
    }
}
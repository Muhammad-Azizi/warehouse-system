<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        $jenisLaporan = $request->input('jenis_laporan', 'semua');

        $dariTanggal = $request->input('dari_tanggal');

        $sampaiTanggal = $request->input('sampai_tanggal');


        /*
        |--------------------------------------------------------------------------
        | MASTER MATERIAL
        |--------------------------------------------------------------------------
        */

        $materials = Material::orderBy('id', 'asc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | BARANG MASUK
        |--------------------------------------------------------------------------
        */

        $barangMasukQuery = BarangMasuk::with('details.material')
            ->latest('tanggal');

        if (!empty($dariTanggal)) {

            $barangMasukQuery->whereDate(
                'tanggal',
                '>=',
                $dariTanggal
            );
        }

        if (!empty($sampaiTanggal)) {

            $barangMasukQuery->whereDate(
                'tanggal',
                '<=',
                $sampaiTanggal
            );
        }

        $barangMasuk = $barangMasukQuery->get();


        /*
        |--------------------------------------------------------------------------
        | BARANG KELUAR
        |--------------------------------------------------------------------------
        */

        $barangKeluarQuery = BarangKeluar::with('details.material')
            ->latest('tanggal');

        if (!empty($dariTanggal)) {

            $barangKeluarQuery->whereDate(
                'tanggal',
                '>=',
                $dariTanggal
            );
        }

        if (!empty($sampaiTanggal)) {

            $barangKeluarQuery->whereDate(
                'tanggal',
                '<=',
                $sampaiTanggal
            );
        }

        $barangKeluar = $barangKeluarQuery->get();


        /*
        |--------------------------------------------------------------------------
        | FILTER JENIS LAPORAN
        |--------------------------------------------------------------------------
        */

        if ($jenisLaporan === 'stok') {

            $barangMasuk = collect();

            $barangKeluar = collect();
        }

        if ($jenisLaporan === 'barang_masuk') {

            $barangKeluar = collect();
        }

        if ($jenisLaporan === 'barang_keluar') {

            $barangMasuk = collect();
        }

        if ($jenisLaporan === 'picking_list') {

            $barangMasuk = collect();
        }


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view('Laporan.index', compact(
            'materials',
            'barangMasuk',
            'barangKeluar',
            'jenisLaporan',
            'dariTanggal',
            'sampaiTanggal'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD EXCEL
    |--------------------------------------------------------------------------
    */

    public function exportExcel(Request $request)
    {
        $jenisLaporan = $request->input(
            'jenis_laporan',
            'semua'
        );

        $dariTanggal = $request->input(
            'dari_tanggal'
        );

        $sampaiTanggal = $request->input(
            'sampai_tanggal'
        );


        /*
        |--------------------------------------------------------------------------
        | Nama File
        |--------------------------------------------------------------------------
        */

        $tanggalFile = now()->format('Y-m-d');

        $namaFile = 'Laporan-Warehouse-' .
            $jenisLaporan .
            '-' .
            $tanggalFile .
            '.xlsx';


        /*
        |--------------------------------------------------------------------------
        | Download Excel
        |--------------------------------------------------------------------------
        */

        return Excel::download(
            new LaporanExport(
                $jenisLaporan,
                $dariTanggal,
                $sampaiTanggal
            ),
            $namaFile
        );
    }
}
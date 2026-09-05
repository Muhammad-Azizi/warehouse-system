<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    /**
     * Menampilkan daftar barang keluar
     */
    public function index(Request $request)
    {
        $query = BarangKeluar::with('details.material');

        // Filter tanggal mulai
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('tanggal', '>=', $request->dari_tanggal);
        }

        // Filter tanggal sampai
        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('tanggal', '<=', $request->sampai_tanggal);
        }

        // Filter tujuan
        if ($request->filled('tujuan')) {
            $query->where('tujuan', 'like', '%' . $request->tujuan . '%');
        }

        $barangKeluars = $query
            ->latest()
            ->get();

        return view('barang-keluar.index', compact('barangKeluars'));
    }


    /**
     * Form tambah barang keluar
     */
    public function create()
    {
        $materials = Material::orderBy('material_number')
            ->get();

        return view('barang-keluar.create', compact('materials'));
    }


    /**
     * Simpan barang keluar
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'tujuan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',

            'materials' => 'required|array|min:1',

            'materials.*.material_id' => [
                'required',
                'exists:materials,id',
            ],

            'materials.*.qty' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);


        DB::transaction(function () use ($request) {

            /*
            |--------------------------------------------------------------------------
            | Generate Nomor Barang Keluar
            |--------------------------------------------------------------------------
            */

            $last = BarangKeluar::latest('id')->first();

            $number = $last ? $last->id + 1 : 1;

            $noKeluar = 'BK-' . date('Y') . '-' . str_pad(
                $number,
                4,
                '0',
                STR_PAD_LEFT
            );


            /*
            |--------------------------------------------------------------------------
            | Simpan Header
            |--------------------------------------------------------------------------
            */

            $barangKeluar = BarangKeluar::create([
                'no_keluar' => $noKeluar,
                'tanggal' => $request->tanggal,
                'tujuan' => $request->tujuan,
                'keterangan' => $request->keterangan,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Simpan Detail
            |--------------------------------------------------------------------------
            */

            foreach ($request->materials as $item) {

                $material = Material::findOrFail(
                    $item['material_id']
                );

                $qty = (int) $item['qty'];


                /*
                |--------------------------------------------------------------------------
                | Cek Stok
                |--------------------------------------------------------------------------
                */

                if ($material->qty_stock < $qty) {

                    throw new \Exception(
                        'Stok material ' .
                        $material->material_number .
                        ' tidak mencukupi. ' .
                        'Stok tersedia: ' .
                        $material->qty_stock
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Simpan Detail
                |--------------------------------------------------------------------------
                */

                $barangKeluar->details()->create([
                    'material_id' => $material->id,
                    'qty' => $qty,
                    'satuan' => $material->uom,
                ]);


                /*
                |--------------------------------------------------------------------------
                | Kurangi Stok
                |--------------------------------------------------------------------------
                */

                $material->decrement('qty_stock', $qty);
            }
        });


        return redirect()
            ->route('barang-keluar.index')
            ->with(
                'success',
                'Barang keluar berhasil disimpan.'
            );
    }


    /**
     * Detail barang keluar
     */
    public function show(BarangKeluar $barangKeluar)
    {
        $barangKeluar->load('details.material');

        return view(
            'barang-keluar.show',
            compact('barangKeluar')
        );
    }


    /**
     * Halaman print barang keluar
     */
    public function print(BarangKeluar $barangKeluar)
    {
        $barangKeluar->load('details.material');

        return view(
            'barang-keluar.print',
            compact('barangKeluar')
        );
    }


    /**
     * Edit
     */
    public function edit(BarangKeluar $barangKeluar)
    {
        //
    }


    /**
     * Update
     */
    public function update(
        Request $request,
        BarangKeluar $barangKeluar
    ) {
        //
    }


    /**
     * Hapus barang keluar
     *
     * Stok dikembalikan ke Master Material
     */
    public function destroy(BarangKeluar $barangKeluar)
    {
        DB::transaction(function () use ($barangKeluar) {

            /*
            |--------------------------------------------------------------------------
            | Ambil semua detail
            |--------------------------------------------------------------------------
            */

            $barangKeluar->load('details');


            /*
            |--------------------------------------------------------------------------
            | Kembalikan stok ke Master Material
            |--------------------------------------------------------------------------
            */

            foreach ($barangKeluar->details as $detail) {

                $material = Material::find($detail->material_id);

                if ($material) {

                    $material->increment(
                        'qty_stock',
                        $detail->qty
                    );
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Hapus detail
            |--------------------------------------------------------------------------
            */

            $barangKeluar->details()->delete();


            /*
            |--------------------------------------------------------------------------
            | Hapus transaksi
            |--------------------------------------------------------------------------
            */

            $barangKeluar->delete();
        });


        return redirect()
            ->route('barang-keluar.index')
            ->with(
                'success',
                'Barang keluar berhasil dihapus dan stok telah dikembalikan.'
            );
    }
}
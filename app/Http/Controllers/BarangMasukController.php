<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    /**
     * Menampilkan daftar barang masuk
     */
    public function index(Request $request)
    {
        $query = BarangMasuk::with('details.material');

        // Filter tanggal
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('tanggal', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('tanggal', '<=', $request->sampai_tanggal);
        }

        // Filter supplier
        if ($request->filled('supplier')) {
            $query->where(
                'supplier',
                'like',
                '%' . $request->supplier . '%'
            );
        }

        $barangMasuks = $query
            ->latest('tanggal')
            ->latest()
            ->get();

        return view(
            'barang-masuk.index',
            compact('barangMasuks')
        );
    }


    /**
     * Form tambah barang masuk
     */
    public function create()
    {
        $materials = Material::orderBy('material_number')->get();

        return view(
            'barang-masuk.create',
            compact('materials')
        );
    }


    /**
     * Simpan barang masuk
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'supplier' => 'required|string|max:255',
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

            // Generate nomor barang masuk
            $last = BarangMasuk::latest('id')->first();

            $number = $last ? $last->id + 1 : 1;

            $noMasuk = 'BM-' . date('Y') . '-' .
                str_pad(
                    $number,
                    4,
                    '0',
                    STR_PAD_LEFT
                );


            // Simpan header
            $barangMasuk = BarangMasuk::create([
                'no_masuk' => $noMasuk,
                'tanggal' => $request->tanggal,
                'supplier' => $request->supplier,
                'keterangan' => $request->keterangan,
            ]);


            // Simpan detail dan tambah stok
            foreach ($request->materials as $item) {

                $material = Material::findOrFail(
                    $item['material_id']
                );

                $qty = (int) $item['qty'];

                $barangMasuk->details()->create([
                    'material_id' => $material->id,
                    'qty' => $qty,
                    'uom' => $material->uom,
                ]);

                // Tambahkan stok
                $material->increment(
                    'qty_stock',
                    $qty
                );
            }
        });


        return redirect()
            ->route('barang-masuk.index')
            ->with(
                'success',
                'Barang masuk berhasil disimpan.'
            );
    }


    /**
     * Detail barang masuk
     */
    public function show(BarangMasuk $barangMasuk)
    {
        $barangMasuk->load('details.material');

        return view(
            'barang-masuk.show',
            compact('barangMasuk')
        );
    }


    /**
     * Hapus barang masuk
     *
     * Stok akan dikurangi kembali
     * sesuai quantity transaksi.
     */
    public function destroy(BarangMasuk $barangMasuk)
    {
        DB::transaction(function () use ($barangMasuk) {

            // Ambil semua detail
            $barangMasuk->load('details');


            // Kembalikan kondisi stok
            // karena barang masuk sebelumnya menambah stok
            foreach ($barangMasuk->details as $detail) {

                $material = Material::find(
                    $detail->material_id
                );

                if ($material) {

                    $material->decrement(
                        'qty_stock',
                        $detail->qty
                    );
                }
            }


            // Hapus detail
            $barangMasuk->details()->delete();


            // Hapus transaksi utama
            $barangMasuk->delete();
        });


        return redirect()
            ->route('barang-masuk.index')
            ->with(
                'success',
                'Barang masuk berhasil dihapus dan stok telah disesuaikan.'
            );
    }
}
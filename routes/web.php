<?php

use App\Http\Controllers\MaterialController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\PickingListController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use App\Models\Material;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;


/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    // Total jenis material
    $totalMaterial = Material::count();

    // Total stok seluruh material
    $totalStock = Material::sum('qty_stock');

    // Barang masuk hari ini
    $barangMasukHariIni = BarangMasuk::whereDate(
        'tanggal',
        today()
    )->count();

    // Barang keluar hari ini
    $barangKeluarHariIni = BarangKeluar::whereDate(
        'tanggal',
        today()
    )->count();

    // Total Picking List
    $totalPickingList = BarangKeluar::count();

    // Picking List terbaru
    $pickingList = BarangKeluar::with('details.material')
        ->latest()
        ->take(5)
        ->get();

    // Barang masuk terbaru
    $barangMasukTerbaru = BarangMasuk::with('details.material')
        ->latest()
        ->take(5)
        ->get();

    // Barang keluar terbaru
    $barangKeluarTerbaru = BarangKeluar::with('details.material')
        ->latest()
        ->take(5)
        ->get();

    return view('dashboard', compact(
        'totalMaterial',
        'totalStock',
        'barangMasukHariIni',
        'barangKeluarHariIni',
        'totalPickingList',
        'pickingList',
        'barangMasukTerbaru',
        'barangKeluarTerbaru'
    ));

})->middleware(['auth'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Master Material
|--------------------------------------------------------------------------
*/

Route::resource('materials', MaterialController::class)
    ->middleware(['auth']);


/*
|--------------------------------------------------------------------------
| Barang Masuk
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Daftar barang masuk
    Route::get('/barang-masuk', [BarangMasukController::class, 'index'])
        ->name('barang-masuk.index');

    // Form tambah barang masuk
    Route::get('/barang-masuk/create', [BarangMasukController::class, 'create'])
        ->name('barang-masuk.create');

    // Simpan barang masuk
    Route::post('/barang-masuk', [BarangMasukController::class, 'store'])
        ->name('barang-masuk.store');

    // Detail barang masuk
    Route::get('/barang-masuk/{barangMasuk}', [BarangMasukController::class, 'show'])
        ->name('barang-masuk.show');

    // Print barang masuk
    Route::get(
        '/barang-masuk/{barangMasuk}/print',
        [BarangMasukController::class, 'print']
    )->name('barang-masuk.print');

    // Hapus barang masuk
    Route::delete('/barang-masuk/{barangMasuk}', [BarangMasukController::class, 'destroy'])
        ->name('barang-masuk.destroy');

});


/*
|--------------------------------------------------------------------------
| Barang Keluar
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Daftar barang keluar
    Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])
        ->name('barang-keluar.index');

    // Form tambah barang keluar
    Route::get('/barang-keluar/create', [BarangKeluarController::class, 'create'])
        ->name('barang-keluar.create');

    // Simpan barang keluar
    Route::post('/barang-keluar', [BarangKeluarController::class, 'store'])
        ->name('barang-keluar.store');

    // Detail barang keluar
    Route::get('/barang-keluar/{barangKeluar}', [BarangKeluarController::class, 'show'])
        ->name('barang-keluar.show');

    // Print barang keluar
    Route::get(
        '/barang-keluar/{barangKeluar}/print',
        [BarangKeluarController::class, 'print']
    )->name('barang-keluar.print');

    // Hapus barang keluar
    Route::delete('/barang-keluar/{barangKeluar}', [BarangKeluarController::class, 'destroy'])
        ->name('barang-keluar.destroy');

});


/*
|--------------------------------------------------------------------------
| Picking List
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Daftar picking list
    Route::get('/picking-list', [PickingListController::class, 'index'])
        ->name('picking-list.index');

    // Detail picking list
    Route::get('/picking-list/{barangKeluar}', [PickingListController::class, 'show'])
        ->name('picking-list.show');

});


/*
|--------------------------------------------------------------------------
| Laporan
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Halaman laporan
    Route::get('/laporan', [LaporanController::class, 'index'])
        ->name('laporan.index');

    // Download laporan Excel
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])
        ->name('laporan.export.excel');

});


/*
|--------------------------------------------------------------------------
| User
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Daftar User
    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');

    // Form tambah User
    Route::get('/users/create', [UserController::class, 'create'])
        ->name('users.create');

    // Simpan User
    Route::post('/users', [UserController::class, 'store'])
        ->name('users.store');

    // Detail User
    Route::get('/users/{user}', [UserController::class, 'show'])
        ->name('users.show');

    // Form edit User
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->name('users.edit');

    // Update User
    Route::put('/users/{user}', [UserController::class, 'update'])
        ->name('users.update');

    // Hapus User
    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->name('users.destroy');

});


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
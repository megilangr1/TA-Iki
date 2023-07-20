<?php

use App\Http\Controllers\AjaxDataController;
use App\Http\Controllers\MainController;
use App\Http\Livewire\Barang\MainIndex as BarangMainIndex;
use App\Http\Livewire\Kategori\MainIndex as KategoriMainIndex;
use App\Http\Livewire\Pegawai\MainIndex as PegawaiMainIndex;
use App\Http\Livewire\PermintaanBarang\MainIndex as PermintaanBarangMainIndex;
use App\Http\Livewire\PermintaanBarang\MainForm as PermintaanBarangMainForm;
use App\Http\Livewire\PengirimanBarang\MainIndex as PengirimanBarangMainIndex;
use App\Http\Livewire\PengirimanBarang\MainForm as PengirimanBarangMainForm;
use App\Http\Livewire\PenerimaanBarang\MainIndex as PenerimaanBarangMainIndex;
use App\Http\Livewire\PenerimaanBarang\MainForm as PenerimaanBarangMainForm;
use App\Http\Livewire\Pos\MainForm as PosMainForm;
use App\Http\Livewire\Pos\MainIndex as PosMainIndex;
use App\Http\Livewire\Toko\MainIndex as TokoMainIndex;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MainController::class, 'index'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::prefix('backend')->name('backend.')->group(function () {
        Route::get('/', [MainController::class, 'main'])->name('main');
    });

    Route::prefix('master-data')->name('master-data.')->group(function() {
        Route::get('/toko', TokoMainIndex::class)->name('toko');
        Route::get('/kategori', KategoriMainIndex::class)->name('kategori');
        Route::get('/barang', BarangMainIndex::class)->name('barang');
    });

    Route::prefix('master-akun')->name('master-akun.')->group(function() {
        Route::get('/pegawai', PegawaiMainIndex::class)->name('pegawai');
    });

    Route::prefix('ajax')->name('ajax.')->middleware(['auth'])->group(function () {
        Route::get('/kategori', [AjaxDataController::class, 'dataKategori'])->name('kategori');
        Route::get('/toko', [AjaxDataController::class, 'dataToko'])->name('toko');
    });
    Route::prefix('ajax')->name('ajax.')->middleware(['auth'])->group(function () {
        Route::get('/kategori', [AjaxDataController::class, 'dataKategori'])->name('kategori');
        Route::get('/toko', [AjaxDataController::class, 'dataToko'])->name('toko');
        Route::get('/gudang', [AjaxDataController::class, 'dataGudang'])->name('gudang');
        Route::get('/barang', [AjaxDataController::class, 'dataBarang'])->name('barang');
    });

    Route::prefix('permintaan-barang')->name('permintaan-barang.')->group(function() {
        Route::get('/', PermintaanBarangMainIndex::class)->name('index');
        Route::get('/create', PermintaanBarangMainForm::class)->name('create');
        Route::get('/{id}/detail', PermintaanBarangMainForm::class)->name('detail');
    });

    Route::prefix('pengiriman-barang')->name('pengiriman-barang.')->group(function() {
        Route::get('/', PengirimanBarangMainIndex::class)->name('index');
        Route::get('/create', PengirimanBarangMainForm::class)->name('create');
        Route::get('/{id}/detail', PengirimanBarangMainForm::class)->name('detail');
    });

    Route::prefix('penerimaan-barang')->name('penerimaan-barang.')->group(function() {
        Route::get('/', PenerimaanBarangMainIndex::class)->name('index');
        Route::get('/create', PenerimaanBarangMainForm::class)->name('create');
        Route::get('/{id}/detail', PenerimaanBarangMainForm::class)->name('detail');
    });

    Route::prefix('pos')->name('pos.')->group(function() {
        Route::get('/', PosMainIndex::class)->name('index');
    });

    Route::get('/point-of-sales', PosMainForm::class)->name('point-of-sales');
});


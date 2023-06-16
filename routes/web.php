<?php

use App\Http\Controllers\AjaxDataController;
use App\Http\Controllers\MainController;
use App\Http\Livewire\Barang\MainIndex as BarangMainIndex;
use App\Http\Livewire\Kategori\MainIndex as KategoriMainIndex;
use App\Http\Livewire\PenerimaanBarang\MainIndex as PenerimaanBarangMainIndex;
use App\Http\Livewire\PenerimaanBarang\MainForm as PenerimaanBarangMainForm;
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

    Route::prefix('ajax')->name('ajax.')->middleware(['auth'])->group(function () {
        Route::get('/kategori', [AjaxDataController::class, 'dataKategori'])->name('kategori');
        Route::get('/toko', [AjaxDataController::class, 'dataToko'])->name('toko');
    });

    
    Route::prefix('penerimaan-barang')->name('penerimaan-barang.')->group(function() {
        Route::get('/', PenerimaanBarangMainIndex::class)->name('index');
        Route::get('/create', PenerimaanBarangMainForm::class)->name('create');
    });
});


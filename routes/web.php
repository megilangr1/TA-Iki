<?php

use App\Http\Controllers\MainController;
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
    });
});


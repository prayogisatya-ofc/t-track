<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\TempeController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function() {
    Route::get('login', [LoginController::class, 'index'])->name('login.index');
    Route::post('login', [LoginController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function() {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/get-seluruh-produksi', [DashboardController::class, 'getSeluruhProduksi'])->name('get_seluruh_produksi');
    Route::get('/get-total-produksi', [DashboardController::class, 'getTotalProduksi'])->name('get_total_produksi');
    Route::get('/get-grafik-produksi', [DashboardController::class, 'getGrafikProduksi'])->name('get_grafik_produksi');
    Route::get('/get-grafik-mingguan', [DashboardController::class, 'getGrafikMingguan'])->name('get_grafik_mingguan');
    Route::get('/get-riwayat-produksi', [DashboardController::class, 'getRiwayatProduksi'])->name('get_riwayat_produksi');

    Route::get('/profil-saya', [ProfilController::class, 'getProfil'])->name('profil_saya');
    Route::post('/profil-saya/update', [ProfilController::class, 'updateProfil'])->name('update_profil');
});

Route::post('/save-tempe', [TempeController::class, 'store'])->name('save_tempe');

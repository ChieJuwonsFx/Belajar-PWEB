<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\kasir\kasirProfileController;
use App\Http\Controllers\Kasir\transaksiKasirController;

Route::middleware(['auth', 'role:Kasir'])->group(function () {
    Route::get('/kasir', [dashboardController::class, 'kasir'])->name('kasir');
    Route::get('/kasir/transaksi', [transaksiKasirController::class, 'index'])->name('kasir.transaksi');
    Route::post('/kasir/transaksi', [transaksiKasirController::class, 'store'])->name('kasir.transaksi.store');
    Route::get('/kasir/transaksi/riwayat', [transaksiKasirController::class, 'riwayat'])->name('kasir.transaksi.riwayat');
    Route::get('/kasir/transaksi/batal', [transaksiKasirController::class, 'batal'])->name('kasir.transaksi.batal');
    Route::get('/kasir/transaksi/selesai', [transaksiKasirController::class, 'selesai'])->name('kasir.transaksi.selesai');
    Route::get('/kasir/transaksi/cancel/{id}', [transaksiKasirController::class, 'cancel'])->name('kasir.transaksi.cancel');
    Route::get('kasir/transaksi/{id}', [transaksiKasirController::class, 'show'])->name('kasir.transaksi.show');
    Route::post('/kasir/transaksi/store', [transaksiKasirController::class, 'store'])->name('kasir.transaksi.store');

    Route::middleware('auth')->group(function () {
        Route::get('/kasir/profile', [kasirProfileController::class, 'edit'])->name('kasir.profile.edit');
        Route::patch('/kasir/profile', [kasirProfileController::class, 'update'])->name('kasir.profile.update');
    });
});

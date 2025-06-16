<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\admin\adminProductController;
use App\Http\Controllers\Kasir\transaksiKasirController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Kasir\LaporanTransaksiController;
use App\Http\Controllers\Kasir\RiwayatTransaksiController;
use App\Http\Controllers\Kasir\TransaksiDibatalkanController;
use App\Http\Controllers\Kasir\TransaksiSelesaiController;

Route::get('/', function () {
    return view('user.home');
})->name('dashboard');

Route::get('/product', function () {
    return view('user.product');
});

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin', [dashboardController::class, 'admin'])->name('admin');
    
    Route::get('/admin/produk', [adminProductController::class, 'index'])->name('admin.produk');
    Route::get('/admin/produk/edit/{id}', [adminProductController::class, 'edit'])->name('admin.produk.edit');
    Route::post('/admin/produk/update/{id}', [adminProductController::class, 'update'])->name('admin.produk.update');
});

Route::middleware(['auth', 'role:Kasir'])->group(function () {
    Route::get('/kasir', [dashboardController::class, 'kasir'])->name('kasir');
    Route::get('/kasir/transaksi', [transaksiKasirController::class, 'index'])->name('kasir.transaksi');
    Route::get('/kasir/riwayat', [RiwayatTransaksiController::class, 'index'])->name('kasir.riwayat');
    Route::get('/kasir/batal', [TransaksiDibatalkanController::class, 'index'])->name('kasir.batal');
    Route::get('/kasir/selesai', [TransaksiSelesaiController::class, 'index'])->name('kasir.selesai');
    Route::post('/kasir/transaksi', [transaksiKasirController::class, 'store'])->name('kasir.transaksi.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(SocialiteController::class)->group(function(){
    route::get('auth/google', [SocialiteController::class, 'googleLogin'])->name('auth.google');
    Route::get('auth/google-callback', 'googleAuthentication')->name('auth.google-callback');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


require __DIR__.'/auth.php';
require __DIR__.'/owner.php';
require __DIR__.'/api.php';
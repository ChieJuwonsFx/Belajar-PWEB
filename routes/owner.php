<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\Owner\ownerUnitController;
use App\Http\Controllers\Owner\ownerStockController;
use App\Http\Controllers\owner\ownerProductController;
use App\Http\Controllers\owner\ownerProfileController;
use App\Http\Controllers\owner\ownerCategoryController;
use App\Http\Controllers\owner\ownerEmployeeController;
use App\Http\Controllers\owner\ownerDashboardController;
use App\Http\Controllers\Owner\ownerStockAdjustmentController;
use App\Http\Controllers\Owner\ownerTransaksiController;

Route::middleware(['auth', 'role:Owner'])->group(function () {
    Route::get('/owner', [ownerDashboardController::class, 'index'])->name('owner.dashboard');
    // Route::get('/owner/dashboard', [ownerDashboardController::class, 'index'])->name('owner');
    Route::get('/owner/report/generate', [ownerDashboardController::class, 'generateReport'])->name('owner.report.generate');
    Route::get('/owner/report/months', [ownerDashboardController::class, 'getAvailableMonths'])->name('owner.report.getMonths');

    Route::middleware('auth')->group(function () {
        Route::get('/owner/profile', [ownerProfileController::class, 'edit'])->name('owner.profile.edit');
        Route::patch('/owner/profile', [ownerProfileController::class, 'update'])->name('owner.profile.update');
    });

    Route::get('/owner/employee', [ownerEmployeeController::class, 'index'])->name('employee');
    Route::post('owner/submit', [ownerEmployeeController::class, 'store'])->name('owner.employee.store');
    Route::put('owner/update/{id}', [ownerEmployeeController::class, 'update'])->name('owner.employee.update');
    Route::get('owner/delete/{id}', [ownerEmployeeController::class, 'delete'])->name('owner.employee.delete');

    Route::get('/owner/produk', [ownerProductController::class, 'index'])->name('owner.produk');
    Route::post('/owner/produk/store', [ownerProductController::class, 'store'])->name('owner.produk.store');
    Route::get('/owner/produk/edit/{id}', [ownerProductController::class, 'edit'])->name('owner.produk.edit');
    Route::put('/owner/produk/update/{id}', [ownerProductController::class, 'update'])->name('owner.produk.update');
    Route::put('/owner/produk/delete/{id}', [ownerProductController::class, 'delete'])->name('owner.produk.delete');
    Route::get('/products/barcode/{kode}', [ownerProductController::class, 'showBarcode'])->name('products.barcode.show');
    Route::get('/products/barcode/{kode}/download', [ownerProductController::class, 'downloadBarcode'])->name('products.barcode.download');

    Route::get('/owner/kategori', [ownerCategoryController::class, 'index'])->name('owner.kategori');
    Route::post('/owner/kategori/store', [ownerCategoryController::class, 'store'])->name('owner.kategori.store');
    Route::put('/owner/kategori/update/{id}', [ownerCategoryController::class, 'update'])->name('owner.kategori.update');
    Route::get('/owner/kategori/delete/{id}', [ownerCategoryController::class, 'delete'])->name('owner.kategori.delete');

    Route::get('/owner/unit', [ownerUnitController::class, 'index'])->name('owner.unit');
    Route::post('/owner/unit/store', [ownerUnitController::class, 'store'])->name('owner.unit.store');
    Route::put('/owner/unit/update/{id}', [ownerUnitController::class, 'update'])->name('owner.unit.update');
    Route::get('/owner/unit/delete/{id}', [ownerUnitController::class, 'delete'])->name('owner.unit.delete');

    Route::post('/owner/stok/store/{id}', [ownerStockController::class, 'store'])->name('owner.stok.store');

    Route::get('/owner/transaksi', [ownerTransaksiController::class, 'index'])->name('owner.transaksi');
    Route::get('/owner/transaksi/{id}', [ownerTransaksiController::class, 'show'])->name('owner.transaksi.show');

    Route::get('/batches', [ownerStockAdjustmentController::class, 'index'])->name('owner.batches');
    Route::post('/batches/store/{id?}', [ownerStockAdjustmentController::class, 'store'])->name('owner.batches.store');
});

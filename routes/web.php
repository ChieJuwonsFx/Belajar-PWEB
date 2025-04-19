<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\Owner\ownerUnitController;
use App\Http\Controllers\Owner\ownerStockController;
use App\Http\Controllers\admin\adminProductController;
use App\Http\Controllers\owner\ownerProductController;
use App\Http\Controllers\owner\ownerCategoryController;
use App\Http\Controllers\owner\ownerEmployeeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Owner\ownerStockAdjustmentController;

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
 
Route::middleware(['auth', 'role:Owner'])->group(function () {
    Route::get('/owner', [dashboardController::class, 'owner'])->name('owner');

    Route::get('/owner/employee', [ownerEmployeeController::class, 'index'])->name('employee');
    Route::post('owner/submit', [ownerEmployeeController::class, 'store'])->name('owner.employee.store');
    Route::put('owner/update/{id}', [ownerEmployeeController::class, 'update'])->name('owner.employee.update');
    Route::get('owner/delete/{id}', [ownerEmployeeController::class, 'delete'])->name('owner.employee.delete');

    Route::get('/owner/produk', [ownerProductController::class, 'index'])->name('owner.produk');
    Route::post('/owner/produk/store', [ownerProductController::class, 'store'])->name('owner.produk.store');
    Route::get('/owner/produk/edit/{id}', [ownerProductController::class, 'edit'])->name('owner.produk.edit');
    Route::put('/owner/produk/update/{id}', [ownerProductController::class, 'update'])->name('owner.produk.update');
    Route::get('/owner/produk/delete/{id}', [ownerProductController::class, 'delete'])->name('owner.produk.delete');

    Route::get('/owner/kategori', [ownerCategoryController::class, 'index'])->name('owner.kategori');
    Route::post('/owner/kategori/store', [ownerCategoryController::class, 'store'])->name('owner.kategori.store');
    Route::put('/owner/kategori/update/{id}', [ownerCategoryController::class, 'update'])->name('owner.kategori.update');
    Route::get('/owner/kategori/delete/{id}', [ownerCategoryController::class, 'delete'])->name('owner.kategori.delete');

    Route::get('/owner/unit', [ownerUnitController::class, 'index'])->name('owner.unit');
    Route::post('/owner/unit/store', [ownerUnitController::class, 'store'])->name('owner.unit.store');
    Route::put('/owner/unit/update/{id}', [ownerUnitController::class, 'update'])->name('owner.unit.update');
    Route::get('/owner/unit/delete/{id}', [ownerUnitController::class, 'delete'])->name('owner.unit.delete');

    Route::post('/owner/stok/store/{id}', [ownerStockController::class, 'store'])->name('owner.stok.store');

    Route::get('/batches', [ownerStockAdjustmentController::class, 'index'])->name('owner.batches');
    Route::post('/batches/store/{id?}', [ownerStockAdjustmentController::class, 'store'])->name('owner.batches.store');
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

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\SocialiteController;
use App\Http\Owner\Controllers\ownerUnitController;
use App\Http\Controllers\admin\adminProductController;
use App\Http\Controllers\owner\ownerProductController;
use App\Http\Controllers\owner\ownerCategoryController;
use App\Http\Controllers\owner\ownerEmployeeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('user.home');
})->name('dashboard');

Route::get('/product', function () {
    return view('user.product');
});

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin', [dashboardController::class, 'admin'])->name('admin');
    
    Route::get('/admin/produk', [adminProductController::class, 'produk'])->name('admin.produk');
    Route::get('/admin/produk/edit/{id}', [adminProductController::class, 'edit'])->name('admin.produk.edit');
    Route::post('/admin/produk/update/{id}', [adminProductController::class, 'update'])->name('admin.produk.update');

    // Route::get('/', [CategoryController::class, 'lihat'])->name('kategori.lihat');
    // Route::post('/store', [CategoryController::class, 'store'])->name('kategori.store');
    // Route::put('/update/{id}', [CategoryController::class, 'update'])->name('kategori.update');
    // Route::delete('/delete/{id}', [CategoryController::class, 'delete'])->name('kategori.delete');
});
 
Route::middleware(['auth', 'role:Owner'])->group(function () {
    Route::get('/owner', [dashboardController::class, 'owner'])->name('owner');
    Route::get('/owner/employee', [ownerEmployeeController::class, 'employee'])->name('employee');
    Route::post('owner/submit', [ownerEmployeeController::class, 'create'])->name('employee.create');
    Route::put('owner/update/{id}', [ownerEmployeeController::class, 'update'])->name('employee.update');
    Route::get('owner/delete/{id}', [ownerEmployeeController::class, 'delete'])->name('employee.delete');
    Route::get('/owner/produk', [ownerProductController::class, 'produk'])->name('owner.produk');
    Route::get('/owner/produk/create', [ownerProductController::class, 'create'])->name('owner.produk.create');
    Route::get('/owner/produk/edit/{id}', [ownerProductController::class, 'edit'])->name('owner.produk.edit');
    Route::post('/owner/produk/update/{id}', [ownerProductController::class, 'update'])->name('owner.produk.update');
    Route::get('/owner/produk/delete/{id}', [ownerProductController::class, 'delete'])->name('owner.produk.delete');
    Route::post('/owner/kategori/create', [ownerCategoryController::class, 'create'])->name('owner.kategori.create');
    Route::put('/owner/kategori/update/{id}', [ownerCategoryController::class, 'update'])->name('owner.kategori.update');
    Route::get('/owner/kategori/delete/{id}', [ownerCategoryController::class, 'delete'])->name('owner.kategori.delete');
    Route::post('/owner/unit/create', [ownerUnitController::class, 'create'])->name('owner.unit.create');
    Route::put('/owner/unit/update/{id}', [ownerUnitController::class, 'update'])->name('owner.unit.update');
    Route::get('/owner/unit/delete/{id}', [ownerUnitController::class, 'delete'])->name('owner.unit.delete');
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

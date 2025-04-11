<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('user.home');
})->name('dashboard');

Route::get('/product', function () {
    return view('user.product');
});

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin');
    
    Route::get('/admin/produk', [AdminController::class, 'produk'])->name('admin.produk');
    Route::get('/admin/produk/create', [AdminController::class, 'create'])->name('produk.create');
    Route::post('/admin/produk/store', [AdminController::class, 'store'])->name('produk.store');
    Route::get('/admin/produk/edit/{id}', [AdminController::class, 'edit'])->name('produk.edit');
    Route::post('/admin/produk/update/{id}', [AdminController::class, 'update'])->name('produk.update');
    Route::get('/admin/produk/delete/{id}', [AdminController::class, 'delete'])->name('produk.delete');

    // Route::get('/', [CategoryController::class, 'lihat'])->name('kategori.lihat');
    // Route::post('/store', [CategoryController::class, 'store'])->name('kategori.store');
    // Route::put('/update/{id}', [CategoryController::class, 'update'])->name('kategori.update');
    // Route::delete('/delete/{id}', [CategoryController::class, 'delete'])->name('kategori.delete');
});
 
Route::middleware(['auth', 'role:Owner'])->group(function () {
    Route::get('/owner', [OwnerController::class, 'dashboard'])->name('owner');
    Route::get('/owner/employee', [EmployeeController::class, 'employee'])->name('employee');
    Route::post('owner/submit', [EmployeeController::class, 'create'])->name('employee.create');
    Route::get('owner/update/{id}', [EmployeeController::class, 'update'])->name('employee.update');
    Route::get('owner/delete/{id}', [EmployeeController::class, 'delete'])->name('employee.delete');
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

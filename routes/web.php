<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
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
    Route::get('/admin/employee', [EmployeeController::class, 'employee'])->name('admin.employee');
    Route::post('admin/submit', [EmployeeController::class, 'createEmployee'])->name('employee.create');
    Route::get('admin/update/{id}', [EmployeeController::class, 'updateEmployee'])->name('employee.update');
    Route::get('admin/delete/{id}', [EmployeeController::class, 'deleteEmployee'])->name('employee.delete');
});
 
// Route::middleware(['auth', 'role:Owner'])->group(function () {
    // Route::get('/owner', [OwnerController::class, 'dashboard'])->name('owner');
    // Route::get('/owner/employee', [OwnerController::class, 'employee'])->name('owner.employee');
    // Route::post('owner/submit', [OwnerController::class, 'createEmployee'])->name('employee.create');
    // Route::get('owner/update/{id}', [OwnerController::class, 'updateEmployee'])->name('employee.update');
    // Route::get('owner/delete/{id}', [OwnerController::class, 'deleteEmployee'])->name('employee.delete');
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(SocialiteController::class)->group(function(){
    route::get('auth/google', [SocialiteController::class, 'googleLogin'])->name('auth.google');
    Route::get('auth/google-callback', 'googleAuthentication')->name('auth.google-callback');
});

// Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware(['auth', 'role:admin']);


// Route::get('posts', [PostController::class, 'tampil'])->name('posts.tampil');
// Route::get('posts/tambah', [PostController::class, 'tambah'])->name('posts.tambah');
// Route::get('posts/submit', [PostController::class, 'submit'])->name('posts.submit');
// Route::get('posts/edit{id}', [PostController::class, 'edit'])->name('posts.edit');
// Route::get('posts/update{id}', [PostController::class, 'update'])->name('posts.update');
// Route::post('posts/delete{id}', [PostController::class, 'delete'])->name('posts.delete');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


require __DIR__.'/auth.php';

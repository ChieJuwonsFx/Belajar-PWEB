<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('user.home',['title' => 'Home']);
})->name('dashboard');

Route::get('/product', function () {
    return view('user.product', ['title' => 'Product']);
});

Route::get('/admin', [AdminController::class, 'dashboard'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin');

Route::get('/admin/produk', function () {
    return view('admin.produk', ['title' => 'Kelola Produk']);
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

// Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware(['auth', 'role:admin']);


// Route::get('posts', [PostController::class, 'tampil'])->name('posts.tampil');
// Route::get('posts/tambah', [PostController::class, 'tambah'])->name('posts.tambah');
// Route::get('posts/submit', [PostController::class, 'submit'])->name('posts.submit');
// Route::get('posts/edit{id}', [PostController::class, 'edit'])->name('posts.edit');
// Route::get('posts/update{id}', [PostController::class, 'update'])->name('posts.update');
// Route::post('posts/delete{id}', [PostController::class, 'delete'])->name('posts.delete');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialiteController;

Route::get('/', function () {
    return view('user.home');
});

Route::get('/dashboard', function () {
    return view('dashboard',['title' => 'Home']);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/bookmark', function () {
    return view('bookmark', ['title' => 'Bookmark']);
});

Route::get('/admin', function () {
    return view('admin.home', ['title' => 'Bookmark']);
});

Route::get('/admin/produk', function () {
    return view('admin.produk', ['title' => 'Bookmark']);
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


require __DIR__.'/auth.php';

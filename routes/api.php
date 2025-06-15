<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TransaksiKasirApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sini kamu bisa mendaftarkan semua route API aplikasi kamu. Route ini
| secara otomatis diberi prefix "api" dan middleware "api".
|
*/

Route::middleware(['auth:sanctum'])->prefix('kasir')->group(function () {
    Route::get('/kasir/produk', [TransaksiKasirApiController::class, 'index']);
});
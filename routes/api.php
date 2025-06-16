<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;

Route::get('/products/search', [ProductApiController::class, 'search'])->name('products.search');
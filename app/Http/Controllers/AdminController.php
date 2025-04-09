<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){
        return view ('admin.home');
        // return view ('dashboard');
    }
    public function produk()
    {
        $products = Product::with(['category'])->orderBy('name', 'asc')->get();

        return view('produk.produk', compact('products'));
    }
}

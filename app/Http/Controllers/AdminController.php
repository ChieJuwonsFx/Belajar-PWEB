<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){
        return view ('admin.home');
    }
    public function produk()
    {
        // $products = Product::with('category') 
        //                 ->orderBy('name', 'asc')
        //                 ->get();
        $products = Product::with(['category', 'images'])->orderBy('name', 'asc')->get();

        return view('admin.produk', compact('products'));
    }
}

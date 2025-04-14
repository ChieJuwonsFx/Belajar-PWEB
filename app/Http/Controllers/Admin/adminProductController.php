<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class adminProductController extends Controller
{
    public function produk(Request $request)
    {
        $categories = Category::all();

        $query = Product::with('category')
                        ->withSum('stocks as total_stok', 'remaining_quantity');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhereHas('category', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%$search%");
                  });
            });
        }
        
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
      
        $products = $query->orderBy('is_available', 'asc')->get();

        return view('owner.produk.produk', compact('products', 'categories'));
    }
}

<?php

namespace App\Http\Controllers\Kasir;

use App\Models\Unit;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class transaksiKasirController extends Controller
{
    public function index(Request $request){
        try{
            $categories = Category::all();
            $units = Unit::all();
    
            $query = Product::with('category', 'unit')
                ->withSum('stocks as stok', 'remaining_quantity')
                ->where([['is_active', true], ['is_available', 'Available']]);
    
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
    
            return view('kasir.transaksi', compact('products', 'categories', 'units'));    
        } catch (\Exception $e) {
            return redirect()->route('kasir.transaksi')->with('alert_failed', 'Terjadi kesalahan saat melakukan load data produk: ' . $e->getMessage());
        }
    }

    public function store(Request $request){
        $transaksi=Transaction::create([

        ]);
    }
}

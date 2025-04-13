<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // public function produk()
    // {
    //     if (Auth::user()->role == 'Admin'||'Owner') {
    //         $products = Product::with('category')
    //             ->withSum('stocks as total_stok', 'remaining_quantity')->orderBy('is_available', 'asc')
    //             ->get(); 
    //     } else {
    //         $products = Product::where('is_available', 'Active')
    //             ->with('category')
    //             ->withSum('stocks as total_stok', 'remaining_quantity')
    //             ->get(); 
    //     }
        
    //     return view('produk.produk', compact('products'));
    // }


    public function produk(Request $request)
    {
        $categories = Category::all();

        $query = Product::with('category')
                        ->withSum('stocks as total_stok', 'remaining_quantity');

        if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Owner') {
        } else {
            $query->where('is_available', 'Active');
        }

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

        return view('produk.produk', compact('products', 'categories'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('produk.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            'name' => $request->name,
            'deskripsi' => $request->deskripsi,
            'harga_jual' => $request->harga_jual,
            'stok' => $request->stok,
            'stok_minimum' => $request->stok_minimum,
            'image' => json_encode([$imagePath]),
            'category_id' => $request->category_id,
            'is_available' => 'Active',
            'created_at' => now(),
        ]);

        return redirect()->route('produk')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $produk = Product::findOrFail($id);
        $categories = Category::all();
        return view('produk.edit', compact('products', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $produk = Product::findOrFail($id);
        // $data = $request->only(['name', 'deskripsi', 'harga_jual', 'stok', 'stok_minimum', 'category_id']);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = json_encode([$imagePath]);
        }

        $produk->update($data);

        return redirect()->route('produk')->with('success', 'Produk berhasil diupdate');
    }

    public function softDelete($id)
    {
        $produk = Product::findOrFail($id);
        $produk->update(['is_available' => 'Inactive']);

        return redirect()->route('produk')->with('success', 'Produk berhasil dinonaktifkan');
    }
}

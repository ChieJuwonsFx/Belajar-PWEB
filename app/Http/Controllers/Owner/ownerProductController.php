<?php

namespace App\Http\Controllers\Owner;

use App\Models\Unit;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ownerProductController extends Controller
{
    public function produk(Request $request)
    {
        $categories = Category::all();
        $units = Unit::all();

        $query = Product::with('category')->with('unit') 
                        ->withSum('stocks as total_stok', 'remaining_quantity')->where('is_active', true);

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

        return view('owner.produk.produk', compact('products', 'categories', 'units'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('owner.produk.create', compact('categories'));
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
        return view('owner.produk.edit', compact('products', 'categories'));
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

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function produk()
    {
        if (Auth::user()->role == 'Admin') {
            $products = Product::with('category')->get(); 
        } else {
            $products = Product::where('is_available', 'Active')->with('category')->get(); 
        }
    
        return view('produk', compact('products'));
    }
    
    public function create()
    {
        $categories = Category::all();
        return view('produk.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'deskripsi' => 'required',
            'harga_jual' => 'required|integer',
            'stok' => 'required|integer',
            'stok_minimum' => 'required|integer',
            'category_id' => 'required',
            'image' => 'required|image|max:2048',
        ]);

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

        $request->validate([
            'name' => 'required',
            'deskripsi' => 'required',
            'harga_jual' => 'required|integer',
            'stok' => 'required|integer',
            'stok_minimum' => 'required|integer',
            'category_id' => 'required',
        ]);

        $data = $request->only(['name', 'deskripsi', 'harga_jual', 'stok', 'stok_minimum', 'category_id']);

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

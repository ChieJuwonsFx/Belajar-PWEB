<?php

namespace App\Http\Controllers\Owner;

use App\Models\Unit;
use App\Models\Stock;
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
        // $imagePath = $request->file('image')->store('products', 'public');

        if($request->is_stock_real == true && $request->is_modal_real==true ){
            $product = Product::create([
                'name' => $request->name,
                'deskripsi' => $request->deskripsi,
                'harga_jual' => $request->harga_jual,
                'stok' => 0,
                'stok_minimum' => $request->min_stok,
                'image' => $request->images_json,
                'is_available' => $request->is_available,
                'is_active' => true,
                'is_stock_real' => $request->is_stock_real,
                'is_modal_real' => $request->is_modal_real,
                'estimasi_modal'=> 0,
                'category_id' => $request->category,
                'unit_id' => $request->unit,
            ]);
            Stock::create([
                'quantity' => $request->stok,
                'remaining_quantity' => $request->stok,
                'harga_modal' => $request->harga_modal,
                'product_id' => $product->id
            ]);
        }
        else{
            Product::create([
                'name' => $request->name,
                'deskripsi' => $request->deskripsi,
                'harga_jual' => $request->harga_jual,
                'stok' => $request->stok,
                'stok_minimum' => $request->min_stok,
                'image' => $request->images_json,
                'is_available' => $request->is_available,
                'is_active' => true,
                'is_stock_real' => $request->is_stock_real,
                'is_modal_real' => $request->is_modal_real,
                'estimasi_modal'=> $request->harga_modal,
                'category_id' => $request->category,
                'unit_id' => $request->unit,
            ]);
        }
        return redirect()->route('owner.produk')->with('success', 'Produk berhasil ditambahkan');
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

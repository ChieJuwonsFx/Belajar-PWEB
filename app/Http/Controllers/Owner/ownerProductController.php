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
    public function index(Request $request)
    {
        // try{
            $categories = Category::all();
            $units = Unit::all();
    
            $query = Product::with('category', 'unit')
                ->withSum('stocks as stok', 'remaining_quantity')
                ->where('is_active', true);
    
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
        // } catch (\Exception $e) {
        //     return redirect()->route('owner.produk')->with('alert_failed', 'Terjadi kesalahan saat melakukan load data produk: ' . $e->getMessage());
        // }

    }

    public function store(Request $request)
    {
        try{
            $isStockReal = filter_var($request->is_stock_real, FILTER_VALIDATE_BOOLEAN);
            $isModalReal = filter_var($request->is_modal_real, FILTER_VALIDATE_BOOLEAN);
    
    
            if($isStockReal && $isModalReal){
                $product = Product::create([
                    'name' => $request->name,
                    'deskripsi' => $request->deskripsi,
                    'harga_jual' => $request->harga_jual,
                    'stok_minimum' => $request->stok_minimum,
                    'stok' => 0,
                    'image' => $request->images_json,
                    'is_available' => $request->is_available,
                    'is_active' => true,
                    'is_stock_real' => $request->is_stock_real,
                    'is_modal_real' => $request->is_modal_real,
                    'estimasi_modal'=> 1,
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
            elseif($isStockReal){
                $product = Product::create([
                    'name' => $request->name,
                    'deskripsi' => $request->deskripsi,
                    'harga_jual' => $request->harga_jual,
                    'stok_minimum' => $request->stok_minimum,
                    'stok' => $request->stok,
                    'image' => $request->images_json,
                    'is_available' => $request->is_available,
                    'is_active' => true,
                    'is_stock_real' => $request->is_stock_real,
                    'is_modal_real' => $request->is_modal_real,
                    'estimasi_modal'=> 1,
                    'category_id' => $request->category,
                    'unit_id' => $request->unit,
                ]);
            }
            else{
                Product::create([
                    'name' => $request->name,
                    'deskripsi' => $request->deskripsi,
                    'harga_jual' => $request->harga_jual,
                    'stok' => 0,
                    'stok_minimum' => $request->stok_minimum,
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
            return redirect()->route('owner.produk')->with('alert_success', 'Produk berhasil ditambahkan');    
        } catch (\Exception $e) {
            return redirect()->route('owner.produk')->with('alert_failed', 'Terjadi kesalahan saat menambahkan produk: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $produk = Product::findOrFail($id);
            $produk->update([
                'name' => $request->name,
                'deskripsi' => $request->deskripsi,
                'harga_jual' => $request->harga_jual,
                'stok_minimum' => $request->stok_minimum,
                'image' => $request->filled('image') ? $request->image : '[]',
                'is_available' => $request->is_available,
                'category_id' => $request->category,
                'unit_id' => $request->unit,
            ]);
    
            return redirect()->route('owner.produk')->with('alert_success', 'Produk berhasil diperbaharui');
        } catch (\Exception $e) {
            return redirect()->route('owner.produk')->with('alert_failed', 'Terjadi kesalahan saat memperbaharui produk: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try{
            $produk = Product::findOrFail($id);
            $produk->update(['is_active' => false]);
    
            return redirect()->route('owner.produk')->with('alert_success', 'Produk berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('owner.produk')->with('alert_failed', 'Terjadi kesalahan saat menghapus produk: ' . $e->getMessage());
        }
    }


}

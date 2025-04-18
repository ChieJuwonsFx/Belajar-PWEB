<?php

namespace App\Http\Controllers\owner;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ownerCategoryController extends Controller
{  
    public function index(){
        try{
            $categories = Category::all();
            return view('owner.produk.kelolaCategory', compact('categories'));
        } catch (\Exception $e) {
            return redirect()->route('owner.kategori')->with('alert_failed', 'Terjadi kesalahan saat melakukan load data kategori: ' . $e->getMessage());
        }
    }

    public function store(Request $request){
        try{
            Category::create([
                'name' => $request->nama
            ]);
            return redirect()->route('owner.kategori')->with('alert_success', 'Kategori baru berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('owner.kategori')->with('alert_failed', 'Terjadi kesalahan saat menambah kategori: ' . $e->getMessage());
        }

    }
    public function update(Request $request, $id){
        try{
            $category =Category::findOrFail($id);
            $category->update([
                'nama' =>$request->nama
            ]);
    
            return redirect()->route('owner.kategori')->with('alert_success', 'Kategori berhasil diperbaharui');
        } catch (\Exception $e) {
            return redirect()->route('owner.kategori')->with('alert_failed', 'Terjadi kesalahan saat memperbaharui kategori: ' . $e->getMessage());
        }
    }
    public function delete($id)
    {
        try{
            $category = Category::findOrFail($id);
    
            $isCategoryUsed = Product::where('category_id', $id)->exists();
        
            if ($isCategoryUsed) {
                return redirect()->route('owner.kategori')->with('alert_failed', 'Kategori tidak bisa dihapus karena masih digunakan di produk.');
            }
        
            $category->delete();
        
            return redirect()->route('owner.kategori')->with('alert_success', 'Kategori berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('owner.kategori')->with('alert_failed', 'Terjadi kesalahan saat menghapus kategori: ' . $e->getMessage());
        }
    }
}

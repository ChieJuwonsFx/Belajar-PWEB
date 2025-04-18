<?php

namespace App\Http\Controllers\Owner;

use App\Models\Unit;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ownerUnitController extends Controller
{
    public function index(){
        $units = Unit::all();
        return view('owner.produk.kelolaUnit', compact('units'));
    }

    public function store(Request $request){
        Unit::create([
            'name' => $request->nama,
            'singkatan' => $request->singkatan
        ]);
        return redirect()->route('owner.unit')->with('alert_success', 'Unit baru berhasil ditambahkan');
    }

    public function update(Request $request, $id){
        $units= Unit::findOrFail($id);
        $units->update([
            'name' => $request->nama,
            'singkatan' => $request->singkatan
        ]);
        return redirect()->route('owner.unit')->with('alert_success', 'Unit baru berhasil ditambahkan');
    }

    public function delete($id)
    {
        try{
            $units = Unit::findOrFail($id);
    
            $isUnitUsed = Product::where('unit_id', $id)->exists();
        
            if ($isUnitUsed) {
                return redirect()->route('owner.unit')->with('alert_failed', 'Unit tidak bisa dihapus karena masih digunakan di produk.');
            }
        
            $units->delete();
        
            return redirect()->route('owner.unit')->with('alert_success', 'Unit berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('owner.unit')->with('alert_failed', 'Terjadi kesalahan saat menghapus unit: ' . $e->getMessage());
        }
    }
}

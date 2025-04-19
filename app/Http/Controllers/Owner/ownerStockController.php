<?php

namespace App\Http\Controllers\Owner;

use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ownerStockController extends Controller
{
    public function store(Request $request, $id){
        $products = Product::findOrFail($id);
        if(!$products->is_stock_real){
            Stock::create([
                'quantity' => $request->quantity,
                'remaining_quantity' => $request->quantity,
                'harga_modal' => $request->harga_modal,
                'product_id' => $products->id
            ]);
            Product::update([
                'stok' => $request->stok,
                'is_stock_real' => true
            ]);
        }
        else{
            Stock::create([
                'quantity' => $request->quantity,
                'remaining_quantity' => $request->quantity,
                'harga_modal' => $request->harga_modal,
                'product_id' => $products->id
            ]);
        }

        return redirect()->route('owner.produk')->with('alert_success', 'Restok produk berhasil dilakukan');
    }
}

<?php

namespace App\Http\Controllers\Owner;

use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ownerStockController extends Controller
{
    public function store(Request $request, $id)
    {
        $products = Product::findOrFail($id);

        Stock::create([
            'quantity' => $request->quantity,
            'remaining_quantity' => $request->quantity,
            'harga_modal' => $request->harga_modal,
            'product_id' => $products->id,
        ]);

        if(!$products->is_stock_real || !$products->is_modal_real){
            $products->update([
                'is_stock_real' => true,
                'is_modal_real' => true
            ]);
        }

        return redirect()->route('owner.produk')->with('alert_success', 'Restok produk berhasil dilakukan');
    }
}
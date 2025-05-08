<?php

namespace App\Http\Controllers\Kasir;

use App\Models\Unit;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionItem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        $product_id = $request->product_id;
        $product = Product::findOrFail($product_id);
        $transaksi = Transaction::create([
            'transaction_type' => 'Offline',
            'total_jual' => $request->total_jual,
            'total_modal' => 0,
            'admin_id' => Auth::id(),
            'customer_offline' => $request->nama_customer,
            'status' => 'Paid'
        ]);

        if($product->is_stock_real && $product->is_modal_real){
            $stock = Stock::where('product', $product_id)->orderby('created_at')->where('remaining_quantity', '>', 0)->first();
            TransactionItem::create([
                'subtotal' => $request->subtotal,
                'quantity' => $request->quantity,
                'product_id' => $request->product_id,
                'harga_modal' => $stock->harga_modal,
                'is_modal_real' => $product->is_modal_real,
                'harga_jual' => $product->harga_jual,
                'stock_id' => $stock->id,
                "transaction_id" => $transaksi->id
            ]);

            $stock->decrement('remaining_quantity', $request->quantity);
        }
    }
}

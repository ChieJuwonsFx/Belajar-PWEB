<?php

namespace App\Http\Controllers\Kasir;

use App\Models\Stock;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class transaksiKasirController extends Controller
{
    public function index(Request $request){
        try{
            $categories = Category::all();
    
            $query = Product::with('category', 'unit')
                ->withSum('stocks as stok', 'remaining_quantity')
                ->where([['is_active', true], ['is_available', 'Available']]);
    
            if ($request->has('category') && $request->category != '') {
                $query->where('category_id', $request->category);

                if ($request->has('search') && $request->search != '') {
                    $search = $request->search;
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
                }
            }
            $products = $query->orderBy('is_available', 'asc')->get();
    
            return view('kasir.transaksi', compact('products', 'categories'));    
        } catch (\Exception $e) {
            return redirect()->route('kasir.transaksi')->with('alert_failed', 'Terjadi kesalahan saat melakukan load data produk: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
            $data = json_decode($request->input('data_transaksi'), true);

            // Buat transaksi
            $transaction = new Transaction();
            $transaction->transaction_type = 'Offline';
            $transaction->total_jual = $data['total_jual_keseluruhan'];
            $transaction->total_modal = $data['total_modal_keseluruhan'] ?? 0;
            $transaction->admin_id = Auth::id();
            $transaction->status = 'Pending';
            $transaction->save();

            // Proses items
            foreach ($data['items'] as $item) {
                $product = Product::find($item['product_id']);
                if (!$product) {
                    throw new \Exception("Produk tidak ditemukan");
                }

                if ($product->is_stock_real) {
                    // Proses stok real (FIFO)
                    $stocks = Stock::where('product_id', $product->id)
                        ->where('remaining_quantity', '>', 0)
                        ->orderBy('created_at', 'asc')
                        ->get();

                    $remainingQty = $item['quantity'];
                    
                    foreach ($stocks as $stock) {
                        if ($remainingQty <= 0) break;

                        $qtyTaken = min($stock->remaining_quantity, $remainingQty);
                        
                        // Simpan detail transaksi
                        $transactionItem = new TransactionItem();
                        $transactionItem->subtotal = $qtyTaken * $item['harga_jual'];
                        $transactionItem->quantity = $qtyTaken;
                        $transactionItem->product_id = $product->id;
                        $transactionItem->harga_modal = $stock->unit_cost ?? 0;
                        $transactionItem->harga_jual = $item['harga_jual'];
                        $transactionItem->is_modal_real = true;
                        $transactionItem->stock_id = $stock->id;
                        $transactionItem->transaction_id = $transaction->id;
                        $transactionItem->save();

                        $stock->remaining_quantity -= $qtyTaken;
                        $stock->save();

                        $remainingQty -= $qtyTaken;
                    }

                    if ($remainingQty > 0) {
                        throw new \Exception("Stok {$product->name} tidak mencukupi");
                    }
                } else {
                    // Proses stok biasa
                    if ($product->stock < $item['quantity']) {
                        throw new \Exception("Stok {$product->name} tidak mencukupi");
                    }

                    $transactionItem = new TransactionItem();
                    $transactionItem->subtotal = $item['harga_jual'] * $item['quantity'];
                    $transactionItem->quantity = $item['quantity'];
                    $transactionItem->product_id = $product->id;
                    $transactionItem->harga_modal = $item['harga_modal'] ?? 0;
                    $transactionItem->harga_jual = $item['harga_jual'];
                    $transactionItem->is_modal_real = false;
                    $transactionItem->transaction_id = $transaction->id;
                    $transactionItem->save();

                    $product->stock -= $item['quantity'];
                    $product->save();
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Transaksi berhasil! ID: ' . $transaction->id);

    }

}
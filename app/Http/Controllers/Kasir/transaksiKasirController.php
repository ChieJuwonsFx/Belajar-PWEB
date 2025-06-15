<?php

namespace App\Http\Controllers\Kasir;

use App\Models\Unit;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class transaksiKasirController extends Controller
{
    public function index(Request $request)
    {
        try {
            $start = now();
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
            // dd(now()->diffForHumans());
            return view('kasir.transaksi', compact('products', 'categories', 'units'));
        } catch (\Exception $e) {
            return redirect()->route('kasir.transaksi')->with('alert_failed', 'Terjadi kesalahan saat melakukan load data produk: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        // dd($request);
        DB::beginTransaction();

        try{
        $totalModal = array_sum(array_column($request->products, 'cost'));
        $transaction = Transaction::create([
            'transaction_type' => 'Offline',
            'total_jual' => $request->total,
            'total_modal' => $totalModal,
            'total_diskon' => $request->discount_amount,
            'admin_id' => Auth::id(),
            'status' => 'Paid',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        foreach ($request->products as $product) {
            $stock = Stock::where('product_id', $product['product_id'])
                ->where('remaining_quantity', '>=', $product['quantity'])
                ->orderBy('expired_at', 'asc')
                ->first();

            if (!$stock) {
                throw new \Exception('Stok tidak mencukupi untuk produk ID: ' . $product['product_id']);
            }

            $stock->decrement('remaining_quantity', $product['quantity']);

            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product['product_id'],
                'stock_id' => $stock->id,
                'quantity' => $product['quantity'],
                'harga_jual' => $product['price'],
                'harga_modal' => $product['cost'],
                'subtotal' => $product['subtotal'],
                'is_modal_real' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        DB::commit();
        return redirect()->route('kasir.transaksi')->with('alert_success', 'Transaksi Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}

<?php

namespace App\Http\Controllers\Kasir;

use App\Models\Unit;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
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

            return view('kasir.transaksi.transaksi', compact('products', 'categories', 'units'));
        } catch (\Exception $e) {
            return redirect()->route('kasir.transaksi')->with('alert_failed', 'Terjadi kesalahan saat melakukan load data produk: ' . $e->getMessage());
        }
    }

public function store(Request $request)
{
    DB::beginTransaction();

    try {
        $data = json_decode($request->input('data_transaksi'), true);
        
        if (!isset($data['items']) || empty($data['items'])) {
            throw new \Exception("Data items transaksi tidak valid");
        }

        $totalModal = 0;
        $totalJual = 0;
        $totalDiskon = 0;
        $totalDiskonAll = $data['diskon_all'] ?? 0;
        
        foreach ($data['items'] as $item) {
            $product = Product::find($item['product_id']);
            if (!$product) {
                throw new \Exception("Produk dengan ID {$item['product_id']} tidak ditemukan");
            }
            
            $hargaModal = $item['harga_modal'] ?? $product->harga_modal;
            if ($hargaModal === null) {
                $hargaModal = $item['harga_jual'] * 0.9; 
            }
            
            $diskonItem = $item['diskon'] ?? 0;
            $totalDiskon += $diskonItem * $item['quantity'];
            $totalModal += $item['quantity'] * $hargaModal;
        }
        
        $totalJualFinal = ($data['total_jual_keseluruhan'] ?? 0) - $totalDiskon - $totalDiskonAll;

        $transaction = new Transaction();
        $transaction->transaction_type = 'Offline';
        $transaction->total_jual = $totalJualFinal;
        $transaction->total_modal = $totalModal;
        $transaction->admin_id = Auth::id();
        $transaction->status = 'Pending';
        $transaction->total_diskon = $totalDiskon;
        $transaction->save();

        foreach ($data['items'] as $item) {
            $product = Product::find($item['product_id']);
            $diskonItem = $item['diskon'] ?? 0;
            $hargaJualSetelahDiskon = $item['harga_jual'] - $diskonItem;
            
            $hargaModal = $item['harga_modal'] ?? $product->harga_modal;
            if ($hargaModal === null) {
                $hargaModal = $item['harga_jual'] * 0.9; 
            }
            
            if ($product->is_stock_real) {
                $stocks = Stock::where('product_id', $product->id)
                    ->where('remaining_quantity', '>', 0)
                    ->orderBy('created_at', 'asc')
                    ->get();

                $remainingQty = $item['quantity'];
                
                foreach ($stocks as $stock) {
                    if ($remainingQty <= 0) break;

                    $qtyTaken = min($stock->remaining_quantity, $remainingQty);
                    
                    $subtotal = $qtyTaken * $hargaJualSetelahDiskon;
                    
                    $transactionItem = new TransactionItem();
                    $transactionItem->subtotal = $subtotal;
                    $transactionItem->quantity = $qtyTaken;
                    $transactionItem->product_id = $product->id;
                    $transactionItem->harga_modal = $stock->harga_modal ?? $hargaModal;
                    $transactionItem->harga_jual = $hargaJualSetelahDiskon;
                    $transactionItem->is_modal_real = true;
                    $transactionItem->stock_id = $stock->id ?? null;
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
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok {$product->name} tidak mencukupi");
                }

                $subtotal = $item['quantity'] * $hargaJualSetelahDiskon;
                
                $transactionItem = new TransactionItem();
                $transactionItem->subtotal = $subtotal;
                $transactionItem->quantity = $item['quantity'];
                $transactionItem->product_id = $product->id;
                $transactionItem->harga_modal = $hargaModal;
                $transactionItem->harga_jual = $hargaJualSetelahDiskon;
                $transactionItem->is_modal_real = false;
                $transactionItem->transaction_id = $transaction->id;
                $transactionItem->save();

                $product->stock -= $item['quantity'];
                $product->save();
            }
        }

        DB::commit();

        return redirect()->back()->with('success', 'Transaksi berhasil! ID: ' . $transaction->id);

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Transaksi gagal: ' . $e->getMessage());
    }
}

    public function batal(Request $request)
    {
        $date = $request->input('date');

        $transactions = Transaction::where('status', 'Canceled')
            ->where('admin_id', Auth::id())
            ->when($date, function ($query, $date) {
                return $query->whereDate('created_at', $date);
            })

            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('kasir.transaksi.batalTransaksi', [
            'transactions' => $transactions,
            'filter_date' => $date,
        ]);
    }

    public function selesai(Request $request)
    {
        $date = $request->input('date');

        $transactions = Transaction::where('status', 'Paid')
            ->where('admin_id', Auth::id())
            ->whereDate('created_at', '<', now()->format('Y-m-d'))
            ->when($date, function ($query, $date) {
                return $query->whereDate('created_at', $date);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('kasir.transaksi.selesaiTransaksi', [
            'transactions' => $transactions,
            'filter_date' => $date,
        ]);
    }

    public function riwayat(Request $request)
    {
        $today = now()->format('Y-m-d');

        $transactions = Transaction::where('admin_id', Auth::id())
            ->whereDate('created_at', $today)  
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('kasir.transaksi.riwayatTransaksi', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Transaction::with(['transactionItems.product', 'transactionItems.stock', 'admin', 'customer'])
            ->findOrFail($id);

        return view('kasir.transaksi.detailTransaksi', compact('transaction'));
    }

    public function cancel($id)
    {
        $transaction = Transaction::findOrFail($id);

        $transaction->update(['status' => 'Canceled']);

        return redirect()->route('kasir.transaksi.riwayat')
            ->with('success', 'Transaksi berhasil dibatalkan');
    }
        public function c($id)
    {
        $transaction = Transaction::findOrFail($id);

        $transaction->update(['status' => 'Canceled']);

        return redirect()->route('kasir.transaksi.riwayat')
            ->with('success', 'Transaksi berhasil dibatalkan');
    }
}

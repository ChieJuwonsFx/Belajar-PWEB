<?php

namespace App\Http\Controllers\Owner;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ownerTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::query()
            ->orderBy('created_at', 'desc')
            ->when($request->date, function ($query, $date) {
                return $query->whereDate('created_at', $date);
            })
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->paginate(10);

        return view('owner.transaksi.riwayatTransaksi', compact('transactions'));
    }
    public function show($id)
    {
        $transaction = Transaction::with(['transactionItems.product', 'transactionItems.stock', 'admin', 'customer'])
            ->findOrFail($id);

        return view('owner.transaksi.detailTransaksi', compact('transaction'));
    }
}

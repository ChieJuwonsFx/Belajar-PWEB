<?php

namespace App\Http\Controllers\owner;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\dashboardController;

class ownerDashboardController extends Controller
{
    public function index()
    {
        // Keuntungan Ekspektasi (dari transaksi tanpa mempertimbangkan status)
        $expectedProfits = DB::table('transactions')
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transaction_id')
            ->selectRaw('MONTH(transactions.created_at) as month,
                        SUM(transaction_items.subtotal) as total_sales,
                        SUM(transaction_items.harga_modal * transaction_items.quantity) as total_cost')
            ->groupBy('month')
            ->get();

        // Keuntungan Sebenarnya (hanya transaksi yang tidak pending)
        $actualProfits = DB::table('transactions')
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transaction_id')
            ->selectRaw('MONTH(transactions.created_at) as month,
                        SUM(transaction_items.subtotal) as total_sales,
                        SUM(transaction_items.harga_modal * transaction_items.quantity) as total_cost')
            ->where('transactions.status', '!=', 'Pending')
            ->groupBy('month')
            ->get();

        // Menghitung total biaya modal dari stok yang rusak atau hilang per bulan
        $stockAdjustmentCosts = DB::table('stock_adjustments')
            ->join('stocks', 'stock_adjustments.stock_id', '=', 'stocks.id')
            ->selectRaw('MONTH(stock_adjustments.created_at) as month, SUM(stock_adjustments.quantity * stocks.harga_modal) as total_lost_cost')
            ->whereIn('stock_adjustments.alasan', ['Rusak', 'Hilang'])
            ->groupBy('month')
            ->get();

        // Array nama bulan
        $monthNames = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        // Format data untuk grafik
        $chartData = collect(range(1, 12))->map(function ($month) use ($expectedProfits, $actualProfits, $stockAdjustmentCosts, $monthNames) {
            $expected = $expectedProfits->firstWhere('month', $month);
            $actual = $actualProfits->firstWhere('month', $month);
            $adjustment = $stockAdjustmentCosts->firstWhere('month', $month);

            // kerugian
            $lostCost = $adjustment ? $adjustment->total_lost_cost : 0;

            // keuntungan bersih
            $realProfit = $actual ? ($actual->total_sales - $actual->total_cost) : 0;

            return [
                'month' => $monthNames[$month],
                'expectedProfit' => $expected ? $expected->total_sales - $expected->total_cost : 0,
                'actualProfit' => $realProfit - $lostCost,
            ];
        });

        // Mengambil 5 transaksi terbaru
        $latestTransactions = DB::table('transactions')
            ->leftJoin('users', 'transactions.user_id', '=', 'users.id')
            ->select('transactions.*', 'users.name as user_name')
            ->orderBy('transactions.created_at', 'desc')
            ->limit(5)
            ->get();

        // Mengambil 5 kerugian terbaru (stok rusak/hilang)
        $latestLosses = DB::table('stock_adjustments')
            ->join('stocks', 'stock_adjustments.stock_id', '=', 'stocks.id')
            ->join('products', 'stocks.product_id', '=', 'products.id')
            ->select(
                'stock_adjustments.created_at',
                'products.name as product_name',
                'stock_adjustments.quantity',
                'stock_adjustments.alasan',
                'stocks.harga_modal'
            )
            ->whereIn('stock_adjustments.alasan', ['Rusak', 'Hilang'])
            ->orderBy('stock_adjustments.created_at', 'desc')
            ->limit(5)
            ->get();

        return redirect()->route('owner.dashboard')
            ->with([
                'chartData' => $chartData,
                'latestTransactions' => $latestTransactions,
                'latestLosses' => $latestLosses
            ]);
    }
}

<?php

namespace App\Http\Controllers\Kasir;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\dashboardController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class dashboardKasirController extends Controller
{
    public function index()
    {
        $auth = Auth::user();

        $endDate = Carbon::today();
        $startDate = Carbon::today()->subDays(29);

        // Keuntungan Ekspektasi harian untuk Kasir
        $expectedProfitsDaily = DB::table('transactions')
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transaction_id')
            ->selectRaw("DATE(transactions.created_at) as date,
                        SUM(transaction_items.harga_jual * transaction_items.quantity - transaction_items.harga_modal * transaction_items.quantity) as total_profit")
            ->where('transactions.admin_id', $auth->id) // Filter berdasarkan kasir yang login
            ->whereBetween('transactions.created_at', [$startDate, $endDate->copy()->endOfDay()])
            ->groupBy('date')
            ->get()->keyBy('date');

        // Kerugian Stok harian yang dicatat oleh Kasir (jika ada)
        $stockAdjustmentCostsDaily = DB::table('stock_adjustments')
            ->join('stocks', 'stock_adjustments.stock_id', '=', 'stocks.id')
            ->selectRaw("DATE(stock_adjustments.created_at) as date, SUM(stock_adjustments.quantity * stocks.harga_modal) as total_lost_cost")
            ->whereIn('stock_adjustments.alasan', ['Rusak', 'Hilang', 'Expired', 'Diretur'])
            ->where('stock_adjustments.created_by', $auth->id) // Filter berdasarkan kasir yang login
            ->whereBetween('stock_adjustments.created_at', [$startDate, $endDate->copy()->endOfDay()])
            ->groupBy('date')
            ->get()->keyBy('date');

        $chartDataDaily = [];
        // Loop untuk 30 hari terakhir
        for ($i = 0; $i <= 29; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dateString = $date->toDateString();
            $dateLabel = $date->format('d M');

            $expected = $expectedProfitsDaily->get($dateString);
            $adjustment = $stockAdjustmentCostsDaily->get($dateString);

            $expectedProfit = $expected->total_profit ?? 0;
            $lostCost = $adjustment->total_lost_cost ?? 0;

            $actualProfit = $expectedProfit - $lostCost;

            $chartDataDaily[] = [
                'date' => $dateLabel,
                'expectedProfit' => $expectedProfit,
                'actualProfit' => $actualProfit,
            ];
        }

        // Total Transaksi yang di-handle Kasir (Paid)
        $totalTransactionsHandled = DB::table('transactions')
            ->where('admin_id', $auth->id)
            ->where('status', 'Paid')
            ->count();

        // Total Profit yang di-handle Kasir (Paid)
        $totalProfitHandled = DB::table('transactions')
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transaction_id')
            ->where('transactions.admin_id', $auth->id)
            ->where('transactions.status', 'Paid')
            ->sum(DB::raw('transaction_items.harga_jual * transaction_items.quantity - transaction_items.harga_modal * transaction_items.quantity')) ?? 0;

        // Total Kerugian Stok yang dicatat Kasir
        $totalLostStockByKasir = DB::table('stock_adjustments')
            ->join('stocks', 'stock_adjustments.stock_id', '=', 'stocks.id')
            ->where('stock_adjustments.created_by', $auth->id)
            ->whereIn('stock_adjustments.alasan', ['Rusak', 'Hilang', 'Expired', 'Diretur'])
            ->sum(DB::raw('stock_adjustments.quantity * stocks.harga_modal')) ?? 0;


        // Transaksi Terbaru yang Dilayani Kasir
        $latestTransactions = DB::table('transactions')
            ->leftJoin('users', 'transactions.admin_id', '=', 'users.id')
            ->select(
                'transactions.*',
                'users.name as user_name',
                DB::raw('(transactions.total_jual - transactions.total_modal) as profit')
            )
            ->where('transactions.admin_id', $auth->id) // Hanya transaksi kasir ini
            ->where('transactions.status', 'Paid')
            ->orderBy('transactions.created_at', 'desc')
            ->limit(5)
            ->get();

        $dataForKasirDashboardView = [
            'chartDataDaily' => $chartDataDaily,
            'latestTransactions' => $latestTransactions,
            'totalTransactionsHandled' => $totalTransactionsHandled,
            'totalProfitHandled' => $totalProfitHandled,
            'totalLostStockByKasir' => $totalLostStockByKasir,
            'kasirName' => $auth->name,
        ];

        // Buat instance dari dashboardController
        $dashboardController = app(\App\Http\Controllers\dashboardController::class);
        return $dashboardController->kasir($dataForKasirDashboardView);
    }
}

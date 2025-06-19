<?php

namespace App\Http\Controllers\owner;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\dashboardController;
use Carbon\Carbon;

class ownerDashboardController extends Controller
{
    public function index()
    {
        // --- Perhitungan Profit Bulanan untuk Grafik ---
        // Keuntungan Ekspektasi (dari semua transaksi, harga jual - harga modal)
        $expectedProfits = DB::table('transactions')
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transaction_id')
            ->selectRaw("MONTH(transactions.created_at) as month,
                        SUM(transaction_items.harga_jual * transaction_items.quantity - transaction_items.harga_modal * transaction_items.quantity) as total_profit")
            ->groupBy('month')
            ->get();

        // Keuntungan Sebenarnya (hanya transaksi yang tidak pending, harga jual - harga modal)
        $actualProfits = DB::table('transactions')
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transaction_id')
            ->selectRaw("MONTH(transactions.created_at) as month,
                        SUM(transaction_items.harga_jual * transaction_items.quantity - transaction_items.harga_modal * transaction_items.quantity) as total_profit")
            ->where('transactions.status', '!=', 'Pending')
            ->groupBy('month')
            ->get();

        // Menghitung total biaya modal dari stok yang rusak atau hilang per bulan
        $stockAdjustmentCosts = DB::table('stock_adjustments')
            ->join('stocks', 'stock_adjustments.stock_id', '=', 'stocks.id')
            ->selectRaw("MONTH(stock_adjustments.created_at) as month, SUM(stock_adjustments.quantity * stocks.harga_modal) as total_lost_cost")
            ->whereIn('stock_adjustments.alasan', ['Rusak', 'Hilang', 'Expired', 'Diretur']) // Memasukkan 'Diretur'
            ->groupBy('month')
            ->get();

        $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        // Format data untuk grafik Bulanan
        $chartData = collect(range(1, 12))->map(function ($month) use ($expectedProfits, $actualProfits, $stockAdjustmentCosts, $monthNames) {
            $expected = $expectedProfits->firstWhere('month', $month);
            $actual = $actualProfits->firstWhere('month', $month);
            $adjustment = $stockAdjustmentCosts->firstWhere('month', $month);

            $lostCost = $adjustment->total_lost_cost ?? 0;
            $realProfitFromSales = $actual->total_profit ?? 0;

            return [
                'month' => $monthNames[$month],
                'expectedProfit' => $expected->total_profit ?? 0,
                'actualProfit' => $realProfitFromSales - $lostCost,
            ];
        });

        // --- Perhitungan Profit Harian, Mingguan, Bulanan (Ringkasan) ---
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY); // Mulai minggu dari Senin
        $startOfMonth = Carbon::now()->startOfMonth();

        // Profit Penjualan Hari Ini
        $salesProfitToday = DB::table('transactions')
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transaction_id')
            ->whereDate('transactions.created_at', $today)
            ->where('transactions.status', 'Paid')
            ->sum(DB::raw('transaction_items.harga_jual * transaction_items.quantity - transaction_items.harga_modal * transaction_items.quantity')) ?? 0;
        // Kerugian Stok Hari Ini
        $lostCostToday = DB::table('stock_adjustments')
            ->join('stocks', 'stock_adjustments.stock_id', '=', 'stocks.id')
            ->whereIn('stock_adjustments.alasan', ['Rusak', 'Hilang', 'Expired', 'Diretur'])
            ->whereDate('stock_adjustments.created_at', $today)
            ->sum(DB::raw('stock_adjustments.quantity * stocks.harga_modal')) ?? 0;

        $profitTodayExpected = $salesProfitToday;
        $profitTodayActual = $salesProfitToday - $lostCostToday;

        // Profit Penjualan Minggu Ini
        $salesProfitThisWeek = DB::table('transactions')
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transaction_id')
            ->whereBetween('transactions.created_at', [$startOfWeek, $today->copy()->endOfDay()])
            ->where('transactions.status', 'Paid')
            ->sum(DB::raw('transaction_items.harga_jual * transaction_items.quantity - transaction_items.harga_modal * transaction_items.quantity')) ?? 0;
        // Kerugian Stok Minggu Ini
        $lostCostThisWeek = DB::table('stock_adjustments')
            ->join('stocks', 'stock_adjustments.stock_id', '=', 'stocks.id')
            ->whereIn('stock_adjustments.alasan', ['Rusak', 'Hilang', 'Expired', 'Diretur'])
            ->whereBetween('stock_adjustments.created_at', [$startOfWeek, $today->copy()->endOfDay()])
            ->sum(DB::raw('stock_adjustments.quantity * stocks.harga_modal')) ?? 0;

        $profitThisWeekExpected = $salesProfitThisWeek;
        $profitThisWeekActual = $salesProfitThisWeek - $lostCostThisWeek;

        // Profit Penjualan Bulan Ini
        $salesProfitThisMonth = DB::table('transactions')
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transaction_id')
            ->whereBetween('transactions.created_at', [$startOfMonth, $today->copy()->endOfDay()])
            ->where('transactions.status', 'Paid')
            ->sum(DB::raw('transaction_items.harga_jual * transaction_items.quantity - transaction_items.harga_modal * transaction_items.quantity')) ?? 0;
        // Kerugian Stok Bulan Ini
        $lostCostThisMonth = DB::table('stock_adjustments')
            ->join('stocks', 'stock_adjustments.stock_id', '=', 'stocks.id')
            ->whereIn('stock_adjustments.alasan', ['Rusak', 'Hilang', 'Expired', 'Diretur'])
            ->whereBetween('stock_adjustments.created_at', [$startOfMonth, $today->copy()->endOfDay()])
            ->sum(DB::raw('stock_adjustments.quantity * stocks.harga_modal')) ?? 0;

        $profitThisMonthExpected = $salesProfitThisMonth;
        $profitThisMonthActual = $salesProfitThisMonth - $lostCostThisMonth;

        // --- Data Grafik Profit Realita Harian (misal 30 hari terakhir) ---
        $startDateDaily = Carbon::today()->subDays(29);
        $endDateDaily = Carbon::today();
        $actualProfitsDailyQuery = DB::table('transactions')
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transaction_id')
            ->selectRaw("DATE(transactions.created_at) as date,
                         SUM(transaction_items.harga_jual * transaction_items.quantity - transaction_items.harga_modal * transaction_items.quantity) as total_profit")
            ->where('transactions.status', 'Paid')
            ->whereBetween('transactions.created_at', [$startDateDaily, $endDateDaily->copy()->endOfDay()])
            ->groupBy('date')
            ->get()->keyBy('date');

        $stockAdjustmentCostsDailyQuery = DB::table('stock_adjustments')
            ->join('stocks', 'stock_adjustments.stock_id', '=', 'stocks.id')
            ->selectRaw("DATE(stock_adjustments.created_at) as date, SUM(stock_adjustments.quantity * stocks.harga_modal) as total_lost_cost")
            ->whereIn('stock_adjustments.alasan', ['Rusak', 'Hilang', 'Expired', 'Diretur'])
            ->whereBetween('stock_adjustments.created_at', [$startDateDaily, $endDateDaily->copy()->endOfDay()])
            ->groupBy('date')
            ->get()->keyBy('date');

        $chartDataDailyRealita = [];
        for ($i = 0; $i <= 29; $i++) {
            $date = $startDateDaily->copy()->addDays($i);
            $dateString = $date->toDateString();
            $dateLabel = $date->format('d M'); // Ex: 01 Jan

            $profit = $actualProfitsDailyQuery->get($dateString)->total_profit ?? 0;
            $lost = $stockAdjustmentCostsDailyQuery->get($dateString)->total_lost_cost ?? 0;

            $chartDataDailyRealita[] = [
                'date' => $dateLabel,
                'actualProfit' => $profit - $lost,
            ];
        }

        // --- Data Grafik Profit Realita Mingguan (misal 10 minggu terakhir) ---
        $endDateWeekly = Carbon::today();
        $startDateWeekly = Carbon::today()->subWeeks(9)->startOfWeek(Carbon::MONDAY); // 10 minggu terakhir

        $actualProfitsWeeklyQuery = DB::table('transactions')
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transaction_id')
            ->selectRaw("WEEK(transactions.created_at, 1) as week_num, YEAR(transactions.created_at) as year, MONTH(transactions.created_at) as month_num,
                          SUM(transaction_items.harga_jual * transaction_items.quantity - transaction_items.harga_modal * transaction_items.quantity) as total_profit")
            ->where('transactions.status', 'Paid')
            ->whereBetween('transactions.created_at', [$startDateWeekly, $endDateWeekly->copy()->endOfDay()])
            ->groupBy('year', 'week_num', 'month_num')
            ->get();

        $stockAdjustmentCostsWeeklyQuery = DB::table('stock_adjustments')
            ->join('stocks', 'stock_adjustments.stock_id', '=', 'stocks.id')
            ->selectRaw("WEEK(stock_adjustments.created_at, 1) as week_num, YEAR(stock_adjustments.created_at) as year, MONTH(stock_adjustments.created_at) as month_num, SUM(stock_adjustments.quantity * stocks.harga_modal) as total_lost_cost")
            ->whereIn('stock_adjustments.alasan', ['Rusak', 'Hilang', 'Expired', 'Diretur'])
            ->whereBetween('stock_adjustments.created_at', [$startDateWeekly, $endDateWeekly->copy()->endOfDay()])
            ->groupBy('year', 'week_num', 'month_num')
            ->get();

        $chartDataWeeklyRealita = [];
        $weeklyProfitMap = collect();
        foreach ($actualProfitsWeeklyQuery as $item) {
            $key = $item->year . '-' . $item->week_num;
            $weeklyProfitMap->put($key, $item->total_profit);
        }
        $weeklyLostCostMap = collect();
        foreach ($stockAdjustmentCostsWeeklyQuery as $item) {
            $key = $item->year . '-' . $item->week_num;
            $weeklyLostCostMap->put($key, $item->total_lost_cost);
        }

        // Loop untuk 10 minggu terakhir
        for ($i = 0; $i <= 9; $i++) {
            $currentWeekDate = $startDateWeekly->copy()->addWeeks($i);
            $weekNumber = $currentWeekDate->isoWeek();
            $year = $currentWeekDate->year;
            $month = $currentWeekDate->month;
            $combinedKey = $year . '-' . $weekNumber;

            // nama bulan dari array $monthNames
            $monthName = $monthNames[$month];

            // Hitung profit dan lost cost untuk minggu ini
            $profit = $weeklyProfitMap->get($combinedKey) ?? 0;
            $lost = $weeklyLostCostMap->get($combinedKey) ?? 0;

            // Hitung minggu ke-N dalam bulan
            $firstDayOfMonth = $currentWeekDate->copy()->startOfMonth();
            $weekOfMonth = $currentWeekDate->weekOfMonth;

            $chartDataWeeklyRealita[] = [
                'week' => 'Minggu Ke-' . $weekOfMonth . ' ' . $monthName,
                'actualProfit' => $profit - $lost,
            ];
        }

        // Mengambil 5 transaksi terbaru
        $latestTransactions = DB::table('transactions')
            ->leftJoin('users', 'transactions.admin_id', '=', 'users.id')
            ->select(
                'transactions.*',
                'users.name as user_name',
                DB::raw('(transactions.total_jual - transactions.total_modal) as profit')
            )
            ->where('transactions.status', 'Paid')
            ->orderBy('transactions.created_at', 'desc')
            ->limit(5)
            ->get();

        // Mengambil 5 kerugian terbaru (stok rusak/hilang/expired/diretur)
        $latestLosses = DB::table('stock_adjustments')
            ->join('stocks', 'stock_adjustments.stock_id', '=', 'stocks.id')
            ->join('products', 'stocks.product_id', '=', 'products.id')
            ->select(
                'stock_adjustments.created_at',
                'products.name as product_name',
                'stock_adjustments.quantity',
                'stock_adjustments.alasan',
                'stocks.harga_modal',
                DB::raw('stock_adjustments.quantity * stocks.harga_modal as total_loss_value')
            )
            ->whereIn('stock_adjustments.alasan', ['Rusak', 'Hilang', 'Expired', 'Diretur'])
            ->orderBy('stock_adjustments.created_at', 'desc')
            ->limit(5)
            ->get();

        // Mengambil total pendapatan (sales), modal (cost), dan kerugian dari stok untuk ditampilkan di ringkasan dashboard
        $totalSales = DB::table('transactions')
            ->where('status', 'Paid')
            ->sum('total_jual') ?? 0;

        $totalCostOfSales = DB::table('transactions')
            ->where('status', 'Paid')
            ->sum('total_modal') ?? 0;

        $totalLostStockCost = DB::table('stock_adjustments')
            ->join('stocks', 'stock_adjustments.stock_id', '=', 'stocks.id')
            ->whereIn('stock_adjustments.alasan', ['Rusak', 'Hilang', 'Expired', 'Diretur'])
            ->sum(DB::raw('stock_adjustments.quantity * stocks.harga_modal')) ?? 0;

        $totalActualProfitOverall = ($totalSales - $totalCostOfSales) - $totalLostStockCost;

        // Kumpulkan semua data yang akan dikirim ke dashboardController
        $dataForDashboardView = [
            'chartData' => $chartData,
            'chartDataDailyRealita' => $chartDataDailyRealita,
            'chartDataWeeklyRealita' => $chartDataWeeklyRealita,
            'latestTransactions' => $latestTransactions,
            'latestLosses' => $latestLosses,
            'totalSales' => $totalSales,
            'totalCostOfSales' => $totalCostOfSales,
            'totalLostStockCost' => $totalLostStockCost,
            'totalActualProfitOverall' => $totalActualProfitOverall,
            'profitTodayExpected' => $profitTodayExpected,
            'profitTodayActual' => $profitTodayActual,
            'profitThisWeekExpected' => $profitThisWeekExpected,
            'profitThisWeekActual' => $profitThisWeekActual,
            'profitThisMonthExpected' => $profitThisMonthExpected,
            'profitThisMonthActual' => $profitThisMonthActual,
        ];

        // Buat instance dari dashboardController
        $dashboardController = app(\App\Http\Controllers\dashboardController::class);
        return $dashboardController->owner($dataForDashboardView);
    }
}

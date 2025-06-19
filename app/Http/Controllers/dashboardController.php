<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    public function owner($ownerData) {
        $chartData = $ownerData['chartData'];
        $latestTransactions = $ownerData['latestTransactions'];
        $latestLosses = $ownerData['latestLosses'];
        $totalSales = $ownerData['totalSales'];
        $totalCostOfSales = $ownerData['totalCostOfSales'];
        $totalLostStockCost = $ownerData['totalLostStockCost'];
        $totalActualProfitOverall = $ownerData['totalActualProfitOverall'];

        $chartDataDailyRealita = $ownerData['chartDataDailyRealita'];
        $chartDataWeeklyRealita = $ownerData['chartDataWeeklyRealita'];

        $profitTodayExpected = $ownerData['profitTodayExpected'];
        $profitTodayActual = $ownerData['profitTodayActual'];
        $profitThisWeekExpected = $ownerData['profitThisWeekExpected'];
        $profitThisWeekActual = $ownerData['profitThisWeekActual'];
        $profitThisMonthExpected = $ownerData['profitThisMonthExpected'];
        $profitThisMonthActual = $ownerData['profitThisMonthActual'];


        return view('owner.home', compact(
            'chartData',
            'latestTransactions',
            'latestLosses',
            'totalSales',
            'totalCostOfSales',
            'totalLostStockCost',
            'totalActualProfitOverall',
            'chartDataDailyRealita',
            'chartDataWeeklyRealita',
            'profitTodayExpected',
            'profitTodayActual',
            'profitThisWeekExpected',
            'profitThisWeekActual',
            'profitThisMonthExpected',
            'profitThisMonthActual'
        ));
    }

    public function kasir(){
        $auth = Auth::user();

        $endDate = Carbon::today();
        $startDate = Carbon::today()->subDays(9);

        $actualProfits = DB::table('transactions')
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transaction_id')
            ->selectRaw('DATE(transactions.created_at) as date,
                        SUM(transaction_items.subtotal) as total_sales,
                        SUM(transaction_items.harga_modal * transaction_items.quantity) as total_cost')
            ->where('status', '!=', 'Pending')
            ->where('status', '!=', 'Canceled')
            ->where('transactions.admin_id', $auth->id)
            ->whereBetween('transactions.created_at', [$startDate, $endDate->copy()->endOfDay()])
            ->groupBy('date')
            ->get()->keyBy('date');

        $chartData = [];
        for ($i = 0; $i < 20; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dateString = $date->toDateString();
            $dateLabel = $date->format('d M');

            $actual = $actualProfits->get($dateString);

            $profit = $actual ? $actual->total_sales - $actual->total_cost : 0;

            $chartData[] = [
                'date' => $dateLabel,
                'profit' => $profit,
            ];
        }

        $latestTransactions = DB::table('transactions')
            ->leftJoin('users', 'transactions.admin_id', '=', 'users.id')
            ->select('transactions.*', 'users.name as user_name')
            ->where('transactions.admin_id', $auth->id)
            ->orderBy('transactions.created_at', 'desc')
            ->limit(5)
            ->get();


        return view ('kasir.home', compact('chartData', 'latestTransactions'));
    }

}

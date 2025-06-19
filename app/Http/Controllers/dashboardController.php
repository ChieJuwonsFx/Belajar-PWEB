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

        // Tambahan untuk Laporan
        $availableYears = $ownerData['availableYears'];
        $availableMonths = $ownerData['availableMonths'];
        $currentYear = $ownerData['currentYear'];
        $currentMonth = $ownerData['currentMonth'];

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
            'profitThisMonthActual',

            'availableYears',
            'availableMonths',
            'currentYear',
            'currentMonth'
        ));
    }

    public function kasir($kasirData){
        $chartDataDaily = $kasirData['chartDataDaily'];
        $latestTransactions = $kasirData['latestTransactions'];
        $totalTransactionsHandled = $kasirData['totalTransactionsHandled'];
        $totalProfitHandled = $kasirData['totalProfitHandled'];
        $totalLostStockByKasir = $kasirData['totalLostStockByKasir'];
        $kasirName = $kasirData['kasirName'];
        $profitTodayKasir = collect($chartDataDaily)->last()['actualProfit'] ?? 0; // Ambil profit hari terakhir dari chartDataDaily

        return view('kasir.home', compact(
            'chartDataDaily',
            'latestTransactions',
            'totalTransactionsHandled',
            'totalProfitHandled',
            'totalLostStockByKasir',
            'kasirName',
            'profitTodayKasir'
        ));
    }

}

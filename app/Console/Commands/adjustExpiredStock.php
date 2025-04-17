<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Stock;
use App\Models\StockAdjustment;
use Illuminate\Console\Command;

class adjustExpiredStock extends Command
{
    protected $signature = 'adjust:expired-stock';
    protected $description = 'Cek stok yang expired hari ini';

    public function handle()
    {
        $today = Carbon::today();

        $expiredStocks = Stock::whereDate('expired_at', $today)->get();

        foreach ($expiredStocks as $stock) {
            StockAdjustment::create([
                'quantity' => $stock->remaining_quantity,
                'alasan' => 'Expired',
                'note' => 'Barang expired secara otomatis pada ' . $today->format('Y-m-d'),
                'stock_id' => $stock->id,
                'created_by' => 1,
            ]);

            $stock->remaining_quantity = 0;
            $stock->save();
        }

        $this->info("Stock expired hari ini berhasil dibuatkan adjustment.");
    }
}

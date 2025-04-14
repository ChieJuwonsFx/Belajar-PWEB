<?php

namespace Database\Seeders;

use App\Models\StockAdjustment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StockAdjustmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alasanList = ['Rusak', 'Hilang', 'Expired', 'Diretur'];

        for ($i = 1; $i <= 10; $i++) {
            StockAdjustment::create([
                'quantity' => rand(1, 5),
                'alasan' => $alasanList[array_rand($alasanList)],
                'note' => 'Catatan penyesuaian stok ke-' . $i,
                'stock_id' => $i,
                'created_by' => 1, 
            ]);
        }
    }
}

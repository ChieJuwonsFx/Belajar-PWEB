<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [['Pieces', 'Pcs'], ['Kilogram', 'kg'], ['Box', 'Box'], ['Liter', 'L'], ['Lusin', 'Lusin']];

        foreach ($units as $name) {
            Unit::create([
                'name' => $name[0],
                'singkatan' => $name[1],                
                'is_active' => true,
            ]);
        }
    }
}

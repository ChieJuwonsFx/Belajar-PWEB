<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Village;
use App\Models\District;
use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        $provinces = Http::get('https://chiejuwonsfx.github.io/api-wilayah-indonesia/json/provinces.json')->json();

        foreach ($provinces as $prov) {
            $provinceDetailUrl = "https://chiejuwonsfx.github.io/api-wilayah-indonesia/json/provinces/{$prov['id']}.json";
            $provinceDetail = Http::get($provinceDetailUrl)->json();

            if (!$provinceDetail) {
                $this->command->error("Gagal ambil detail provinsi untuk ID {$prov['id']}");
                continue;
            }

            Province::create([
                'id' => $prov['id'],
                'nama_provinsi' => $prov['nama']
            ]);

            foreach ($provinceDetail['cities'] as $city) {
                City::create([
                    'id' => $city['id'],
                    'nama_kabupaten' => $city['nama'],
                    'province_id' => $prov['id'],
                ]);
            }

            foreach ($provinceDetail['districts'] as $district) {
                District::create([
                    'id' => $district['id'],
                    'nama_kecamatan' => $district['nama'],
                    'city_id' => $district['id_kab'],
                ]);
            }

            foreach ($provinceDetail['villages'] as $village) {
                Village::create([
                    'id' => $village['id'],
                    'nama_desa' => $village['nama'],
                    'district_id' => $village['id_kec'],
                ]);
            }

            $this->command->info("✅ Selesai seed provinsi {$prov['nama']}");
        }
    }
}

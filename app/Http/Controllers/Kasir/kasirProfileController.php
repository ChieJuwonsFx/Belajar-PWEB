<?php

namespace App\Http\Controllers\kasir;

use App\Models\City;
use App\Models\Village;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class kasirProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user()->load('village.district.city.province');
        return view('kasir.profile', ['user' => $user]);
    }

    public function update(Request $request): RedirectResponse
    {
        try {
            $user = $request->user();

            Log::info('Incoming Request Data:', $request->all());

            $provinsiId = $request->input('provinsi');
            $kabupatenId = $request->input('kabupaten');
            $kecamatanId = $request->input('kecamatan');
            $desaId = $request->input('desa');

            $provinsiNama = Http::get("https://chiejuwonsfx.github.io/api-wilayah-indonesia/json/provinces.json")
                ->collect()
                ->firstWhere('id', $provinsiId)['nama'];

            $kabupatenNama = Http::get("https://chiejuwonsfx.github.io/api-wilayah-indonesia/json/regencies/{$provinsiId}.json")
                ->collect()
                ->firstWhere('id', $kabupatenId)['nama'];

            $kecamatanNama = Http::get("https://chiejuwonsfx.github.io/api-wilayah-indonesia/json/districts/{$kabupatenId}.json")
                ->collect()
                ->firstWhere('id', $kecamatanId)['nama'];

            $desaNama = Http::get("https://chiejuwonsfx.github.io/api-wilayah-indonesia/json/villages/{$kecamatanId}.json")
                ->collect()
                ->firstWhere('id', $desaId)['nama'];

            $province = Province::firstOrCreate([
                'id_provinsi' => $provinsiId
            ], [
                'nama_provinsi' => $provinsiNama
            ]);

            $city = City::firstOrCreate([
                'id_kabupaten' => $kabupatenId
            ], [
                'nama_kabupaten' => $kabupatenNama,
                'province_id' => $province->id_provinsi
            ]);

            $district = District::firstOrCreate([
                'id_kecamatan' => $kecamatanId
            ], [
                'nama_kecamatan' => $kecamatanNama,
                'city_id' => $city->id_kabupaten
            ]);

            $village = Village::firstOrCreate([
                'id_desa' => $desaId
            ], [
                'nama_desa' => $desaNama,
                'district_id' => $district->id_kecamatan
            ]);

            $user->fill([
                'name' => $request->name,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'desa_id' => $village->id_desa,
            ]);

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            if ($request->hasFile('image')) {
                $user->image = $request->file('image')->store('users', 'public');
            }

            $user->save();

            return redirect()->back()->with('alert_success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('alert_failed', 'Terjadi kesalahan saat memperbarui profil: ' . $e->getMessage());
        }
    }
}

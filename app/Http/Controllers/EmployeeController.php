<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\Village;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class EmployeeController extends Controller
{
    public function employee()
    {
        $users = User::with('village.district.city.province')->whereNotIn('role', ['Owner', 'User'])->where('status', 'Active')
        ->orderBy('role', 'asc')->get();
        
        return view('owner.employee.employee', compact('users'));

    }
    
    public function create(Request $request)
    {
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

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->fill([
                'name' => $request->name,
                'no_hp' => $request->no_hp,
                'role' => $request->role,
                'alamat' => $request->alamat,
                'desa_id' => $village->id_desa,
                'status' => 'Active'
            ]);

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
        } else {
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'role' => $request->role,
                'password' => Hash::make($request->password),
                'alamat' => $request->alamat,
                'desa_id' => $village->id_desa,
                'status' => 'Active'
            ]);
        }

        if ($request->hasFile('image')) {
            $user->image = $request->file('image')->store('users', 'public');
        } else if (!$user->exists) {
            $user->image = 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/michael-gough.png';
        }

        $user->save();

        return redirect()->route('employee')->with('alert_success', 'Karyawan baru berhasil ditambahkan!');
    }
    public function update(Request $request, $id){
        $users = User::findOrFail($id);
        $users->role = $request->role;
        $users->save();
    
        return redirect()->route('employee')->with('alert_success', 'Role karyawan berhasil diperbaharui!');
    }    
    public function delete($id){
        $users = User::findOrFail($id);
        $users->status = 'Inactive';
        $users->save();
        return redirect()->route('employee')->with('alert_success', 'Karyawan berhasil dihapus!');
    }       
}

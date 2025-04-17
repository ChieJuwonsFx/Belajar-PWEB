<?php

namespace App\Http\Controllers\Owner;

use App\Models\City;
use App\Models\User;
use App\Models\Village;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class ownerEmployeeController extends Controller
{
    public function employee()
    {
        try{
            $users = User::with('village.district.city.province')->whereNotIn('role', ['Owner', 'User'])->where('is_active', true)
            ->orderBy('role', 'asc')->get();
            
            return view('owner.employee.employee', compact('users'));
        } catch (\Exception $e) {
            return redirect()->route('owner.produk')->with('alert_failed', 'Terjadi kesalahan saat melakukan load data karyawan: ' . $e->getMessage());
        }
    }
    
    public function create(Request $request)
    {
        try{
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
                    'is_active' => true
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
                    'is_active' => true
                ]);
            }
    
            if ($request->hasFile('image')) {
                $user->image = $request->file('image')->store('users', 'public');
            } else if (!$user->exists) {
                $user->image = 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/michael-gough.png';
            }
    
            $user->save();
    
            return redirect()->route('employee')->with('alert_success', 'Karyawan baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('owner.produk')->with('alert_failed', 'Terjadi kesalahan saat menambahkan karyawan baru: ' . $e->getMessage());
        }

    }
    public function update(Request $request, $id){
        try{
            $users = User::findOrFail($id);
            $users->update([
                'role' => $request->role
            ]);
        
            return redirect()->route('employee')->with('alert_success', 'Role karyawan berhasil diperbaharui!');
        } catch (\Exception $e) {
            return redirect()->route('owner.produk')->with('alert_failed', 'Terjadi kesalahan saat memperbaharui role karyawan: ' . $e->getMessage());
        }

    }    
    public function delete($id){
        try{
            $users = User::findOrFail($id);
            
            $users->update([
                'is_active' => false
            ]);
            return redirect()->route('employee')->with('alert_success', 'Karyawan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('owner.produk')->with('alert_failed', 'Terjadi kesalahan saat menghapus data karyawan: ' . $e->getMessage());
        }
    }       
}

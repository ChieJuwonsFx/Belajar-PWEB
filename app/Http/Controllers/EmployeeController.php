<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\Village;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function employee()
    {
        $users = User::with('village.district.city.province')->whereNotIn('role', ['Owner', 'User'])->where('status', 'Active')
        ->orderBy('role', 'asc')->get();
        
        return view('owner.employee.employee', compact('users'));

    }
    
    
    public function create(Request $request){
         $province = Province::firstOrCreate([
            'id_provinsi' => $request->provinsi_id
        ], [
            'nama_provinsi' => $request->provinsi_nama
        ]);
        
        $city = City::firstOrCreate([
            'id_kabupaten' => $request->kabupaten_id
        ], [
            'nama_kabupaten' => $request->kabupaten_nama,
            'province_id' => $province->id_provinsi
        ]);
        
        $district = District::firstOrCreate([
            'id_kecamatan' => $request->kecamatan_id
        ], [
            'nama_kecamatan' => $request->kecamatan_nama,
            'city_id' => $city->id_kabupaten
        ]);
        
        $village = Village::firstOrCreate([
            'id_desa' => $request->desa_id
        ], [
            'nama_desa' => $request->desa_nama,
            'district_id' => $district->id_kecamatan
        ]);
        
        $user = User::where('email', $request->email)->first();
    
        if ($user) {
            $user->name = $request->name;
            $user->no_hp = $request->no_hp;
            $user->role = $request->role;
            $user->alamat = $request->alamat;
            $user->desa_id = $village->id_desa;
            $user->status = 'Active';
    
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
    
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('users', 'public');
                $user->image = $imagePath;
            }
    
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->no_hp = $request->no_hp;
            $user->role = $request->role;
            $user->password = Hash::make($request->password);
            $user->alamat = $request->alamat;
            $user->desa_id = $village->id_desa;
            $user->status = 'Active';
    
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('users', 'public');
                $user->image = $imagePath;
            } else {
                $user->image = 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/michael-gough.png' . urlencode($request->name); 
            }
        }
    
        $user->save();
    
        return redirect()->route('employee')->with('success', 'Employee berhasil ditambahkan!');
    }

    public function update(Request $request, $id){
        $users = User::findOrFail($id);
        $users->role = $request->role;
        $users->save();
    
        return redirect()->route('employee')->with('success', 'Role berhasil diperbarui!');
    }    
    public function delete($id){
        $users = User::findOrFail($id);
        $users->status = 'Inactive';
        $users->save();
    
        return redirect()->route('employee')->with('success', 'Karyawan berhasil dipecat!');
    }       
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function employee()
    {
        $users = User::whereNotIn('role', ['Admin', 'User'])->where('status', 'Active')
                     ->orderBy('role', 'asc')
                     ->get();
    
        return view('employee.employee', compact('users'));
    }
    
    
    public function createEmployee(Request $request){
        $user = User::where('email', $request->email)->first();
    
        if ($user) {
            $user->name = $request->name;
            $user->telp = $request->telp;
            $user->role = $request->role;
            $user->alamat = $request->alamat;
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
            $user->telp = $request->telp;
            $user->role = $request->role;
            $user->password = Hash::make($request->password);
            $user->alamat = $request->alamat;
            $user->status = 'Active';
    
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('users', 'public');
                $user->image = $imagePath;
            } else {
                $user->image = 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/michael-gough.png' . urlencode($request->name); 
            }
        }
    
        $user->save();
    
        return redirect()->route('admin.employee')->with('success', 'Employee berhasil ditambahkan!');
    }



    public function updateEmployee(Request $request, $id){
        $users = User::findOrFail($id);
        $users->role = $request->role;
        $users->save();
    
        return redirect()->route('admin.employee')->with('success', 'Role berhasil diperbarui!');
    }    
    public function deleteEmployee($id){
        $users = User::findOrFail($id);
        $users->status = 'Inactive';
        $users->save();
    
        return redirect()->route('admin.employee')->with('success', 'Karyawan berhasil dipecat!');
    }       
}

<?php

namespace App\Http\Owner\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ownerUnitController extends Controller
{
    public function create(Request $request){
        Unit::create([
            'name' => $request->nama,
            'singkatan' => $request->singkatan
        ]);
        return redirect()->route('owner.produk')->with('alert_success', 'Unit baru berhasil ditambahkan');
    }
}

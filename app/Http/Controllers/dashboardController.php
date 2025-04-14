<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function admin(){
        return view ('admin.home');
    }
    public function owner(){
        return view ('owner.home');
    }
    // public function kasir(){
    //     return view ('kasir.home');
    // }
}

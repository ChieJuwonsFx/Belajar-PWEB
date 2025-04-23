<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    public function admin(){
        return view ('admin.home');
    }
    public function owner() {
        return view('owner.home');
    }
    public function kasir(){
        return view ('kasir.home');
    }
}

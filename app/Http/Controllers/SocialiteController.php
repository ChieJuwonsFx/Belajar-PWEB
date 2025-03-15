<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function googleLogin (){
        return Socialite::driver('google')->redirect();
    }

    public function googleAuthentication(){
        $googleUser = Socialite::driver('google')->user();
        $user = User::where('email', $googleUser->email)->first();
        // dd($googleUser); // Memeriksa data yang diterima dari Google
        if ($user){
            Auth::login($user);
            return redirect()->route('/');
        }
        else{
            $userData = User::create(
                [
                    // 'google_id' => $googleUser->id,
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => Hash::make('123456789'),
                ]);
            // dd($userData); 
            if ($userData){
                Auth::login($userData);
                return redirect()->route('/');
            }
        }
    }
}

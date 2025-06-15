<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleAuthentication()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::where('email', $googleUser->email)->first();
        
        if ($user) {
            Auth::login($user);
        } else {
            $user = User::create([
                'google_id' => $googleUser->id,
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => Hash::make('123456789'),
                'role' => 'User', 
            ]);
            
            Auth::login($user);
        }

        return $this->redirectToRoleBasedRoute($user->role);
    }

    protected function redirectToRoleBasedRoute($role)
    {
        switch ($role) {
            case 'Kasir':
                return redirect()->route('kasir');
            case 'Owner':
                return redirect()->route('owner');
            default:
                return redirect()->route('dashboard');
        }
    }
}
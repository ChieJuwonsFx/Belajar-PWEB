<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */

    public function store(LoginRequest $request): RedirectResponse
    {
        try{
            $request->authenticate();
            $request->session()->regenerate();

            if ($request->user()->role == 'Admin') {
                return redirect('admin');
            } elseif ($request->user()->role == 'Kasir') {
                return redirect('kasir');
            } elseif ($request->user()->role == 'Owner') {
                return redirect('owner');
            }

            return redirect('/'); 
        } catch (ValidationException $e) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password yang kamu masukkan salah, coba lagi ya!'],
            ]);
        }
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

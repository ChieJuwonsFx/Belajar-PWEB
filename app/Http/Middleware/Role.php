<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. Handle guest users
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        // 2. Handle admin/kasir access
        if ($userRole !== $role) {
            // 3. Custom redirect for users
            if ($userRole === 'User') {
                return redirect()->route('user.home'); // Pastikan route ini ada
            }
            
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
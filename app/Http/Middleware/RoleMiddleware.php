<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Belum login → redirect ke login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Role tidak sesuai → redirect ke login juga
        if (!in_array(Auth::user()->role, $roles)) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
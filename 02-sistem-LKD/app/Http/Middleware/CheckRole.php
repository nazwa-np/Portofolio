<?php

namespace App\Http\Middleware;

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        // Periksa apakah user login sesuai dengan role yang dibutuhkan
        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request);
        }

        return redirect('/'); // Jika tidak, kembalikan ke halaman home
    }
}


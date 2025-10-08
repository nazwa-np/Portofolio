<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request; // Pastikan Request di-import di sini
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}

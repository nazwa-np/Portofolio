<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next)
    {
        // Mendapatkan role pengguna saat ini
        $role = auth()->user()->role;

        // Memeriksa role pengguna dan melakukan pengalihan sesuai dengan role
        if ($role === 'PTI') {
            return $next($request);  // Jika role PTI, lanjutkan ke halaman berikutnya
        }

        if ($role === 'TI') {
            return $next($request);  // Jika role Admin, lanjutkan ke halaman berikutnya
        }

        if ($role === 'PTE') {
            return $next($request);  // Jika role Dosen, lanjutkan ke halaman berikutnya
        }

        if ($role === 'TRSE') {
            return $next($request);  // Jika role Dosen, lanjutkan ke halaman berikutnya
        }

        if ($role === 'superadmin') {
            return $next($request);  // Jika role Dosen, lanjutkan ke halaman berikutnya
        }

        // Jika role tidak dikenali, arahkan ke halaman 'home' dengan pesan error
        return redirect()->route('home')->with('error', 'Role tidak dikenali');
    }
}


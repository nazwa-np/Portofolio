<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validasi form login
        $request->validate([
            'username' => ['required', function($attribute, $value, $fail) {
                if (strlen($value) < 5) {
                    $fail($attribute . ' harus diisi minimal 5 huruf.');
                }
            }],
            'password' => ['required', 'string', 'min:6', 'max:20'],
        ]);

        // Cek apakah user ada
        $user = User::where('username', $request->username)->first();

        Log::info('Login attempt', ['username' => $request->username]);

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            Log::info('User logged in', ['user' => $user->username]);

            // Redirect berdasarkan role
            return $this->redirectUserBasedOnRole($user);
        } else {
            // Jika user tidak ada atau password salah
            Log::warning('Login failed', ['username' => $request->username]);

            // Return with an error message
            return back()->with('error', 'User tidak ditemukan atau password salah!');
        }
    }

    protected function redirectUserBasedOnRole($user)
    {
        if ($user->role === 'superadmin') {
            return redirect()->route('superadmin.index');
        } elseif ($user->role === 'ti') {
            return redirect()->route('adminti.index1');
        } elseif ($user->role === 'pti') {
            return redirect()->route('adminpti.index2');
        } elseif ($user->role === 'pte') {
            return redirect()->route('adminpte.index3');
        } elseif ($user->role === 'trse') {
            return redirect()->route('admintrse.index4');
        }

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

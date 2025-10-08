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
                if (!(ctype_digit($value) && strlen($value) == 10) && !(is_string($value) && strlen($value) >= 5 && strlen($value) <= 15)) {
                    $fail($attribute.' harus berupa angka 10 digit atau string teks (5-15 karakter).');
                }
            }],
            'password' => ['required', 'string', 'min:8', 'max:20'],
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
            return redirect()->route('manage.users');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.index');
        } elseif ($user->role === 'dosen') {
            return redirect()->route('layanan');
        }

        return redirect()->route('home'); // Default redirect
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

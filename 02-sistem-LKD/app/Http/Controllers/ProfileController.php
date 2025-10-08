<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Dosen;
use Illuminate\Routing\Controller;

class ProfileController extends Controller
{
    public function profile()
    {
        // Ambil NIDN dari pengguna yang sedang login
        $nidn = Auth::user()->username;

        // Ambil data dosen berdasarkan NIDN
        $dosen = Dosen::where('nidn', $nidn)->first();

        if (!$dosen) {
            return redirect()->back()->with('error', 'Dosen tidak ditemukan.');
        }

        // Kirim data dosen ke view
        return view('dosen.profile', compact('dosen'));
    }
}
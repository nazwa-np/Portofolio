<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PangkatGol;

class PangkatGolController extends Controller
{
    // Method untuk menampilkan form input data Pangkat/Golongan
    public function create()
    {
        return view('pangkat_gol.create'); // Pastikan ada file view 'pangkat_gol/create.blade.php'
    }

    // Method untuk menyimpan data Pangkat/Golongan ke database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nm_pangkat' => 'required|string|max:100',
        ]);

        // Simpan data ke database
        PangkatGol::create([
            'nm_pangkat' => $request->nm_pangkat,
        ]);

        return redirect()->route('pangkat_gol.create')->with('success', 'Data pangkat/golongan berhasil disimpan.');
    }

    // Method untuk menampilkan data Pangkat/Golongan (opsional)
    public function index()
    {
        $dataPangkatGol = PangkatGol::all();
        return view('pangkat_gol.index', compact('dataPangkatGol'));
    }
}

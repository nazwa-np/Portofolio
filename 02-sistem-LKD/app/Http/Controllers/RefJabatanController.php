<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RefJabatan;

class RefJabatanController extends Controller
{
    // Method untuk menampilkan form input data jabatan
    public function create()
    {
        return view('ref_jabatan.create'); // Pastikan ada file view 'ref_jabatan/create.blade.php'
    }

    // Method untuk menyimpan data jabatan ke database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nm_jabatan' => 'required|string|max:100',
            'kum' => 'required|integer',
        ]);

        // Simpan data ke database
        RefJabatan::create([
            'nm_jabatan' => $request->nm_jabatan,
            'kum' => $request->kum,
        ]);

        return redirect()->route('ref_jabatan.create')->with('success', 'Data jabatan berhasil disimpan.');
    }

    // Method untuk menampilkan data jabatan (opsional)
    public function index()
    {
        $dataJabatan = RefJabatan::all();
        return view('ref_jabatan.index', compact('dataJabatan'));
    }
}

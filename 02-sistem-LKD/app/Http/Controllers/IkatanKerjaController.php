<?php 

namespace App\Http\Controllers;

use App\Models\IkatanKerja; // Pastikan Anda mengimpor model

class IkatanKerjaController extends Controller
{
    public function show($someId) // Metode untuk menampilkan detail ikatan kerja
    {
        // Mengambil data ikatan kerja berdasarkan ID
        $ikatanKerja = IkatanKerja::where('id_ikatan_kerja', $someId)->first();

        // Cek apakah data ditemukan
        if (!$ikatanKerja) {
            return response()->json(['message' => 'Ikatan kerja tidak ditemukan'], 404);
        }

        // Mengembalikan data ke view atau sebagai response
        return view('ikatan_kerja.show', compact('ikatanKerja'));
    }
}

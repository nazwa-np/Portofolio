<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Serdos;

class SerdosController extends Controller
{
    // Method untuk menampilkan form input data serdos
    public function create()
    {
        return view('serdos.create'); // Pastikan ada file view 'serdos/create.blade.php'
    }

    // Method untuk menyimpan data serdos ke database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nidn' => 'required|string|max:20',
            'no_sertifikat' => 'required|string|max:50',
            'tahun' => 'required|digits:4|integer',
            'id_gol2' => 'required|integer',
            'tmt_pangkat' => 'nullable|date',
            'file_serdos' => 'nullable|file|mimes:pdf|max:2048',
            'tgl_inpt' => 'required|date',
            'status_serdos' => 'required|string|max:50',
            'ket_serdos' => 'nullable|string',
            'soft_delete' => 'nullable|boolean',
            'verified_at' => 'nullable|date',
            'idpwi' => 'nullable|integer',
            'jns_dok_serdos' => 'nullable|string|max:50',
            'komen_serdos' => 'nullable|string',
            'no_registrasi' => 'nullable|string|max:50',
        ]);

        // Simpan data ke database
        $serdos = new Serdos();
        $serdos->nidn = $request->nidn;
        $serdos->no_sertifikat = $request->no_sertifikat;
        $serdos->tahun = $request->tahun;
        $serdos->id_gol2 = $request->id_gol2;
        $serdos->tmt_pangkat = $request->tmt_pangkat;
        $serdos->tgl_inpt = $request->tgl_inpt;
        $serdos->status_serdos = $request->status_serdos;
        $serdos->ket_serdos = $request->ket_serdos;
        $serdos->soft_delete = $request->soft_delete ?? 0;
        $serdos->verified_at = $request->verified_at;
        $serdos->idpwi = $request->idpwi;
        $serdos->jns_dok_serdos = $request->jns_dok_serdos;
        $serdos->komen_serdos = $request->komen_serdos;
        $serdos->no_registrasi = $request->no_registrasi;

        // Handle file upload jika ada
        if ($request->hasFile('file_serdos')) {
            $file = $request->file('file_serdos');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads/serdos', $fileName, 'public');
            $serdos->file_serdos = $fileName;
        }

        $serdos->save();

        return redirect()->route('serdos.create')->with('success', 'Data serdos berhasil disimpan.');
    }

    // Method untuk menampilkan data serdos (opsional)
    public function index()
    {
        $dataSerdos = Serdos::all();
        return view('serdos.index', compact('dataSerdos'));
    }
}

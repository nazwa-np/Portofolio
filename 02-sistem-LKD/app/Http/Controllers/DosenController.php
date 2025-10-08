<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    // Menyimpan data dosen ke database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'npsn' => 'required|string|max:50',
            'nama_pt' => 'required|string|max:255',
            'nm_sdm' => 'required|string|max:255',
            'jk' => 'required|string|max:1',
            'tmpt_lahir' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'nm_ibu_kandung' => 'required|string|max:255',
            'stat_kawin' => 'required|string|max:20',
            'nik' => 'required|string|max:20|unique:dosen,nik',
            'nidn' => 'required|string|max:20|unique:dosen,nidn',
            'password' => 'required|string|min:8',
        ]);

        // Menyimpan data dosen ke database
        $dosen = new Dosen();
        $dosen->npsn = $request->input('npsn');
        $dosen->nama_pt = $request->input('nama_pt');
        $dosen->nm_sdm = $request->input('nm_sdm');
        $dosen->jk = $request->input('jk');
        $dosen->tmpt_lahir = $request->input('tmpt_lahir');
        $dosen->tgl_lahir = $request->input('tgl_lahir');
        $dosen->nm_ibu_kandung = $request->input('nm_ibu_kandung');
        $dosen->stat_kawin = $request->input('stat_kawin');
        $dosen->nik = $request->input('nik');
        $dosen->nidn = $request->input('nidn');
        $dosen->password = bcrypt($request->input('password')); // Enkripsi password
        
        // Simpan ke database
        $dosen->save();

        return redirect()->back()->with('success', 'Dosen berhasil ditambahkan.');
    }

}
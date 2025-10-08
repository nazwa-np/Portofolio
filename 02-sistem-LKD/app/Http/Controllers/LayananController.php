<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dosen;
use App\Models\Layanan;
use Illuminate\Support\Facades\Log;

class LayananController extends Controller
{
    public $timestamps = true;

    // Metode untuk memetakan status ikatan kerja dosen
    public function mapIkatanKerja($id)
    {
        $mapping = [
            'A' => 'Dosen Tetap',
            'B' => 'Dosen PNS DPK',
            'C' => 'Dosen Honorer',
            'D' => 'DOSEN HONORER',
            'E' => 'Dokter Pendidik Klinis',
            'F' => 'Dosen Tetap BH',
            'G' => 'Dosen Tidak Tetap',
            'H' => 'P3K ASN',
            'I' => 'Dosen dengan Perjanjian Kerja',
            'J' => 'Instruktur',
            'K' => 'Tutor',
            'L' => 'JFT (Jabatan Fungsional Tertentu)',
        ];

        return $mapping[$id] ?? 'Tidak Diketahui';
    }

    // Menampilkan data dosen yang sedang login
    public function index()
    {
        $nidn = Auth::user()->username; // Mendapatkan NIDN dari pengguna yang login
        $dosen = Dosen::with(['ikatanKerja', 'refJabatan', 'pangkatGol', 'serdos'])
            ->where('nidn', $nidn)
            ->first();

        if (!$dosen) {
            return redirect()->back()->with('error', 'Dosen tidak ditemukan.');
        }

        $status = $this->mapIkatanKerja($dosen->id_ikatan_kerja);

        // Menyiapkan data untuk dikirim ke view
        $data = [
            'nidn' => $dosen->nidn,
            'nama' => $dosen->nm_sdm,
            'nomor_sertifikat' => optional($dosen->serdos)->no_sertifikat ?? 'N/A',
            'status' => $status,
            'kode_pt' => $dosen->npsn,
            'nama_pt' => $dosen->nama_pt,
            'kode_prodi' => $dosen->kode_prodi,
            'nama_prodi' => $dosen->prodi,
            'jab_fungsional' => optional($dosen->refJabatan)->nm_jabatan ?? 'N/A',
            'golongan_pangkat' => optional($dosen->pangkatGol)->nm_pangkat ?? 'N/A',
        ];

        return view('dosen.layanan', compact('data'));
    }

    // Menampilkan data layanan berdasarkan NIDN
    public function show($nidn)
    {
        $data = Layanan::where('nidn', $nidn)->first();

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Membuat path lengkap untuk file PDF yang diunggah
        $data->pdf_file = asset('storage/uploads/' . $data->pdf_file); 

        return view('dosen.tampildata', compact('data'));
    }

    // Menyimpan data layanan ke dalam database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'upload_file' => 'required|mimes:pdf|max:200480',  // Validasi file PDF dengan ukuran maksimal 200MB
            'nidn' => 'required|string',
            'nama' => 'required|string',
            'nomor_sertifikat' => 'required|string',
            'status' => 'required|string',
            'kode_pt' => 'required|string',
            'nama_pt' => 'required|string',
            'kode_prodi' => 'required|string',
            'nama_prodi' => 'required|string',
            'jab_fungsional' => 'required|string',
            'golongan_pangkat' => 'required|string',
        ]);

        try {
            // Mengambil file yang diunggah
            $file = $request->file('upload_file');

            // Menyimpan file ke dalam folder 'public/uploads' dengan nama file yang unik
            $filePath = $file->store('uploads', 'public');

            // Menyiapkan data untuk disimpan ke database
            $dataToStore = [
                'nidn' => $request->nidn,
                'nama' => $request->nama,
                'nomor_sertifikat' => $request->nomor_sertifikat,
                'status' => $request->status,
                'kode_pt' => $request->kode_pt,
                'nama_pt' => $request->nama_pt,
                'kode_prodi' => $request->kode_prodi,
                'nama_prodi' => $request->nama_prodi,
                'jabatan_fungsional' => $request->jab_fungsional,
                'golongan_pangkat' => $request->golongan_pangkat,
                'upload_file' => basename($filePath),  // Menyimpan hanya nama file, bukan path lengkap
            ];

            Log::info('Data yang akan disimpan:', $dataToStore);

            // Menyimpan data ke database
            $saved = Layanan::create($dataToStore);

            if ($saved) {
                return redirect()->route('layanan')->with('success', 'Data berhasil disimpan!');
            } else {
                return redirect()->back()->with('error', 'Data gagal disimpan di database. Silakan coba lagi.');
            }
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan saat menyimpan data: '.$e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data. Pesan kesalahan: '.$e->getMessage());
        }
    }
}

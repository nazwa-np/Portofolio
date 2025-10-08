<?php
namespace App\Http\Controllers;

use App\Models\Layanan; // Import the Layanan model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        // Ambil hanya data yang memiliki status verifikasi 'pending'
        $layanans = Layanan::where('verifikasi', 'pending')->get();
        return view('admin.index', compact('layanans'));
    }

    public function showLayanan($nidn)
    {
        $data = Layanan::where('nidn', $nidn)->first();

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Periksa dan buat path publik untuk PDF
        // Pastikan pathnya benar sesuai dengan file yang diupload
        $data->pdf_file = asset('storage/uploads/' . $data->pdf_file); 

        return view('admin.show', compact('data'));
    }
    

    public function verifikasi(Request $request)
    {
        // Validasi input
        $request->validate([
            'nidn' => 'required',
            'verifikasi' => 'required|in:approved,rejected',
        ]);
    
        // Log informasi untuk debugging
        Log::info("Verifikasi NIDN: {$request->nidn}, Status: {$request->verifikasi}");
    
        // Ambil data layanan berdasarkan NIDN
        $layanan = Layanan::where('nidn', $request->nidn)->first(); // Perbaiki: gunakan 'nidn' bukan 'NIDN'
    
        if (!$layanan) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
    
        // Update status berdasarkan hasil verifikasi
        $layanan->verifikasi = $request->verifikasi; // Mengupdate kolom verifikasi
        $layanan->save();
    
        return redirect()->route('admin.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function approved()
    {
        // Ambil hanya data yang memiliki status verifikasi 'approved'
        $layanans = Layanan::where('verifikasi', 'approved')->get();
        return view('admin.approved', compact('layanans'));
    }

    public function rejected()
    {
        // Ambil hanya data yang memiliki status verifikasi 'rejected'
        $layanans = Layanan::where('verifikasi', 'rejected')->get();
        return view('admin.rejected', compact('layanans'));
    }

    public function downloadPDF($nidn)
    {
        // Cari data layanan berdasarkan NIDN
        $layanan = Layanan::where('nidn', $nidn)->first();
    
        // Cek apakah data dan file PDF ada
        if (!$layanan || !$layanan->upload_file) {
            return redirect()->back()->with('error', 'File PDF tidak ditemukan.');
        }
    
        // Tentukan path file PDF
        $filePath = storage_path('app/public/uploads/' . $layanan->upload_file);
    
        // Periksa apakah file ada di path tersebut
        if (!file_exists($filePath)) {
            Log::error("File tidak ditemukan di server: " . $filePath);
            return redirect()->back()->with('error', 'File PDF tidak ditemukan di server.');
        }
    
        // Mengunduh file PDF
        return response()->download($filePath);
    }
    
    public function viewPDF($nidn)
    {
        // Cari data layanan berdasarkan NIDN
        $layanan = Layanan::where('nidn', $nidn)->first();
    
        // Cek apakah data dan file PDF ada
        if (!$layanan || !$layanan->upload_file) {
            return redirect()->back()->with('error', 'File PDF tidak ditemukan.');
        }
    
        // Tentukan path file PDF
        $filePath = storage_path('app/public/uploads/' . $layanan->upload_file);
    
        // Periksa apakah file ada di path tersebut
        if (!file_exists($filePath)) {
            Log::error("File tidak ditemukan di server: " . $filePath);
            return redirect()->back()->with('error', 'File PDF tidak ditemukan di server.');
        }
    
        // Menampilkan file PDF di browser
        return response()->file($filePath);
    }
    
    
    
}

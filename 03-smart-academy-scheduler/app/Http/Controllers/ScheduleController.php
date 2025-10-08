<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Services\GeneticScheduler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    /**
     * Menampilkan halaman jadwal.
     */
    public function index()
    {
        $jadwal = Jadwal::all();
        return view('jadwal.jadwal', compact('jadwal'));
    }

    public function index2()
    {
        $jadwal = Jadwal::all(); // atau sesuai query yang kamu gunakan
        return view('jadwal.adminti', compact('jadwal'));
    }

    public function index3()
    {
        $jadwal = Jadwal::all(); // atau sesuai query yang kamu gunakan
        return view('jadwal.adminpti', compact('jadwal'));
    }

    public function index4()
    {
        $jadwal = Jadwal::all(); // atau sesuai query yang kamu gunakan
        return view('jadwal.adminpte', compact('jadwal'));
    }

    public function index5()
    {
        $jadwal = Jadwal::all(); // atau sesuai query yang kamu gunakan
        return view('jadwal.admintrse', compact('jadwal'));
    }


    public function generate()
    {
        try {
            // Ambil koneksi database
            $pdo = DB::connection()->getPdo();
            $dbConn = DB::connection();

            // Inisialisasi scheduler
            $scheduler = new GeneticScheduler($dbConn, $pdo);

            // Jalankan algoritma genetika
            $schedule = $scheduler->runGeneticAlgorithm();

            return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil digenerate.');
        } catch (\Exception $e) {
            // Log error jika gagal
            Log::error('Gagal menjalankan algoritma genetika: ' . $e->getMessage());
            return redirect()->route('jadwal.index')->with('error', 'Gagal generate jadwal. Silakan periksa log.');
        }
    }

    /**
     * Mereset seluruh data jadwal.
     */
    public function reset()
    {
        try {
            Jadwal::truncate();
            return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil direset.');
        } catch (\Exception $e) {
            Log::error('Gagal reset jadwal: ' . $e->getMessage());
            return redirect()->route('jadwal.index')->with('error', 'Gagal reset jadwal. Silakan periksa log.');
        }
    }
}

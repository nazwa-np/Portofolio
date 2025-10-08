<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConstraintsDosen;
use App\Models\ConstraintsRuang;
use App\Models\kelas;
use App\Models\ConstraintsKelas;
use Illuminate\Support\Facades\DB;

class ConstraintsController extends Controller
{

    public function index()
    {
        return view('superadmin.constraints.index');
    }




    public function dosen()
    {
        $constraints = ConstraintsDosen::all();
        return view('superadmin.constraints.dosen', compact('constraints'));
    }

    public function showDosenInsert()
    {
        $dataTI   = DB::table('data_ti')->select('dosen')->get();
        $dataPTI  = DB::table('data_pti')->select('dosen')->get();
        $dataPTE  = DB::table('data_pte')->select('dosen')->get();
        $dataTRSE = DB::table('data_trse')->select('dosen')->get();


        $dosens = collect()
            ->merge($dataTI)
            ->merge($dataPTI)
            ->merge($dataPTE)
            ->merge($dataTRSE)
            ->unique('dosen') 
            ->sortBy('dosen')
            ->values(); 
        return view('superadmin.constraints.dosen_insert', compact('dosens'));
    }

    public function DosenStore(Request $request)
    {
        $request->validate([
            'dosen' => 'required',
            'hari' => 'required',
            'jam_ke' => 'required|array',
            'jam_ke.*' => 'integer|between:1,12',
            'status' => 'required|in:Tersedia,Tidak Tersedia'
        ]);


        $jam_ke = $request->input('all_jam') ? range(1, 12) : $request->input('jam_ke');

        foreach ($jam_ke as $jam) {
            ConstraintsDosen::create([
                'dosen' => $request->dosen,
                'hari' => $request->hari,
                'jam_ke' => $jam, // Pastikan nama field sesuai dengan database
                'status' => $request->status
            ]);
        }

        return redirect()->route('superadmin.constraints.dosen_insert')
                    ->with('success', 'Data constraints berhasil disimpan');
    }

    public function destroyDosen($id)
    {
        $item = ConstraintsDosen::findOrFail($id);
        $item->delete();
        return redirect()->route('superadmin.constraints.dosen')->with('success', 'Data constraints dosen berhasil dihapus.');
    }




    public function ruangan()
    {
        $ruangans = ConstraintsRuang::all();
        return view('superadmin.constraints.ruangan', compact('ruangans'));
    }

    public function showRuanganInsert()
    {
        $ruangans = DB::table('ruang_kelas')->get();


        $kodeMks = collect()
            ->merge(DB::table('save_data_ti')->select('kode_mk', 'matkul', 'prodi')->get())
            ->merge(DB::table('save_data_pti')->select('kode_mk', 'matkul', 'prodi')->get())
            ->merge(DB::table('save_data_pte')->select('kode_mk', 'matkul', 'prodi')->get())
            ->merge(DB::table('save_data_trse')->select('kode_mk', 'matkul', 'prodi')->get())
            ->unique('kode_mk')
            ->values(); 
        return view('superadmin.constraints.ruangan_insert', compact('ruangans', 'kodeMks'));
    }

    public function getMatkulByKode($kode_mk)
    {
        $tables = ['save_data_ti', 'save_data_pti', 'save_data_pte', 'save_data_trse'];

        foreach ($tables as $table) {
            $data = DB::table($table)
                ->where('kode_mk', $kode_mk)
                ->select('matkul', 'prodi')
                ->first();

            if ($data) {
                return response()->json($data);
            }
        }

        return response()->json(['matkul' => '', 'prodi' => ''], 404);
    }

    public function RuanganStore(Request $request)
    {
        $request->validate([
            'kode_mk' => 'required|string',
            'matkul'  => 'required|string',
            'prodi'   => 'required|string',
            'jenis_kelas' => 'required|string',
            'lokal'   => 'required|string',
            'kapasitas' => 'required|integer'
        ]);


        ConstraintsRuang::create([
            'kode_mk' => $request->kode_mk,
            'matkul'  => $request->matkul,
            'prodi'   => $request->prodi,
            'jenis_kelas' => $request->jenis_kelas,
            'lokal'   => $request->lokal,
            'kapasitas' => $request->kapasitas,
        ]);

        return redirect()->route('superadmin.constraints.ruangan_insert')->with('success', 'Ruang kelas berhasil ditambahkan');
    }

    public function destroyRuangan($id)
    {
        $item = ConstraintsRuang::findOrFail($id);
        $item->delete();
        return redirect()->route('superadmin.constraints.ruangan')->with('success', 'Data Ruangan berhasil dihapus.');
    }




    public function kelas()
    {
        $kelas = Kelas::all();
        return view('superadmin.kelas', compact('kelas'));
    }

    public function showKelasInsert()
    {

        $kelasData = DB::table('kelas')->select('kode_seksi', 'nama_kelas', 'prodi')->get();
        
        return view('superadmin.constraints.kelas_insert', compact('kelasData'));
    }

    public function KelasStore(Request $request)
    {
        $request->validate([
            'kode_seksi' => 'required|string',
            'nama_kelas' => 'required|string',
            'prodi' => 'required|string',
            'max_mahasiswa' => 'required|integer|min:1'
        ]);


        $existing = Kelas::where('kode_seksi', $request->kode_seksi)->first();
        
        if ($existing) {
            return redirect()->back()
                ->withErrors(['kode_seksi' => 'Kode seksi sudah ada dalam constraints.'])
                ->withInput();
        }


        Kelas::create([
            'kode_seksi' => $request->kode_seksi,
            'nama_kelas' => $request->nama_kelas,
            'prodi' => $request->prodi,
            'max_mahasiswa' => $request->max_mahasiswa
        ]);

        return redirect()->route('superadmin.constraints.kelas_insert')
            ->with('success', 'Constraint kelas berhasil ditambahkan');
    }

    public function getKelasByKodeSeksi($kode_seksi)
    {
        $kelas = DB::table('kelas')
            ->where('kode_seksi', $kode_seksi)
            ->select('nama_kelas', 'prodi')
            ->first();

        if ($kelas) {
            return response()->json($kelas);
        }

        return response()->json(['nama_kelas' => '', 'prodi' => ''], 404);
    }

    public function destroyKelas($id)
    {
        $item = Kelas::findOrFail($id);
        $item->delete();
        return redirect()->route('superadmin.kelas')
            ->with('success', 'Data constraint kelas berhasil dihapus.');
    }
}
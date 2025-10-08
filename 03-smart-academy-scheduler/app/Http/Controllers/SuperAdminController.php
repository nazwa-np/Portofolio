<?php

namespace App\Http\Controllers;

use App\Models\Constraints;
use App\Models\User;
use App\Models\Hari;
use App\Models\Jam;
use App\Models\Kelas;
use App\Models\RuangKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 

class SuperAdminController extends Controller
{
    // Tampilkan daftar user
    public function index()
    {
        $users = User::all();
        return view('superadmin.index', compact('users'));
    }

    // Tampilkan form tambah user
    public function create()
    {
        return view('superadmin.insert'); 
    }

    // Simpan data user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:6',
            'role' => 'required|string' 
        ]);

        User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]);

        return redirect()->route('superadmin.create')->with('success', 'Data berhasil disimpan');
    }

    // Tampilkan form edit user
    public function edit(User $user)
    {
        return view('superadmin.edit', compact('user'));
    }

    // Update data user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|string|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:6'
        ]);

        $data = $request->only('username');
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('superadmin.index')->with('success', 'Data berhasil diperbarui.');
    }

    // Hapus user
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('superadmin.index')->with('success', 'Data berhasil dihapus.');
    }

    // ================================
    // RUANG KELAS SECTION
    // ================================

    // Tampilkan daftar ruang kelas
    public function ruangIndex()
    {
        $ruang_kelas = RuangKelas::all();
        return view('superadmin.ruangIndex', compact('ruang_kelas'));
    }

    // Tampilkan form tambah ruang kelas
    public function ruangCreate()
    {
        return view('superadmin.ruangInsert'); 
    }

    // Simpan data ruang kelas
    public function ruangStore(Request $request)
    {
        $request->validate([
            'lokal' => 'required|string',
            'jenis_kelas'  => 'required|string',
            'kapasitas'  => 'required|integer'
        ]);

        RuangKelas::create($request->only('lokal', 'jenis_kelas', 'kapasitas'));

        return redirect()->route('superadmin.ruangCreate')->with('success', 'Ruang kelas berhasil ditambahkan');
    }

    // Tampilkan form edit ruang kelas
    public function ruangEdit(RuangKelas $ruang_kelas)
    {
        return view('superadmin.ruangEdit', compact('ruang_kelas'));
    }

    // Update data ruang kelas
    public function ruangUpdate(Request $request, RuangKelas $ruang_kelas)
    {
        $request->validate([
            'lokal' => 'required|string',
            'jenis_kelas'  => 'required|string',
            'kapasitas'  => 'required|integer'
        ]);

        $ruang_kelas->update($request->only('lokal', 'jenis_kelas', 'kapasitas'));

        return redirect()->route('superadmin.ruangIndex')->with('success', 'Ruang kelas berhasil diperbarui');
    }

    // Hapus ruang kelas
    public function ruangDestroy(RuangKelas $ruang_kelas)
    {
        $ruang_kelas->delete();

        return redirect()->route('superadmin.ruangIndex')->with('success', 'Ruang kelas berhasil dihapus');
    }

    public function jam()
    {
        $jam = Jam::all();
        return view('superadmin.jam', compact('jam'));
    }


    public function kelasIndex()
    {
        $kelas = Kelas::all();
        return view('superadmin.kelasIndex', compact('kelas'));
    }

    // Tampilkan form tambah ruang kelas
    public function kelasCreate()
    {
        $kelas = DB::table('kelas')->get();

        $data_seksi = DB::table('save_data_ti')
            ->select('kode_seksi')
            ->union(DB::table('save_data_pti')->select('kode_seksi'))
            ->union(DB::table('save_data_pte')->select('kode_seksi'))
            ->union(DB::table('save_data_trse')->select('kode_seksi'))
            ->get();

        return view('superadmin.kelasInsert', ['kelas' => $data_seksi]);
    }


    // Simpan data ruang kelas
    public function kelasStore(Request $request)
    {
        $request->validate([
            'kode_seksi' => 'required|string',
            'kode_mk'  => 'required|string',
            'prodi'  => 'required|string',
            'group'  => 'required|string',
            'jml_mhs'  => 'required|integer',
        ]);

        Kelas::create($request->only('kode_seksi', 'kode_mk', 'prodi', 'group', 'jml_mhs'));

        return redirect()->route('superadmin.kelasCreate')->with('success', 'Kelas berhasil ditambahkan');
    }

    public function getKodeSeksi($kode_seksi)
    {
        // Gabungkan semua tabel
        $data = DB::table('save_data_ti')->where('kode_seksi', $kode_seksi)->first()
            ?? DB::table('save_data_pti')->where('kode_seksi', $kode_seksi)->first()
            ?? DB::table('save_data_pte')->where('kode_seksi', $kode_seksi)->first()
            ?? DB::table('save_data_trse')->where('kode_seksi', $kode_seksi)->first();

        if ($data) {
            return response()->json([
                'kode_mk' => $data->kode_mk ?? '',
                'prodi'   => $data->prodi ?? '',
                'group'   => $data->group ?? '',
            ]);
        }

        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }


    // Tampilkan form edit ruang kelas
    public function kelasEdit(Kelas $kelas)
    {
        return view('superadmin.kelasEdit', compact('kelas'));
    }

    // Update data ruang kelas
    public function kelasUpdate(Request $request, Kelas $kelas)
    {
        $request->validate([
            'kode_seksi' => 'required|string',
            'kode_mk'  => 'required|string',
            'prodi'  => 'required|string',
            'group'  => 'required|string',
            'jml_mhs'  => 'required|integer',
        ]);

        $kelas->update($request->only('kode_seksi', 'kode_mk', 'prodi', 'group', 'jml_mhs'));

        return redirect()->route('superadmin.ruangIndex')->with('success', 'Kelas berhasil diperbarui');
    }

    // Hapus ruang kelas
    public function kelasDestroy(Kelas $kelas)
    {
        $kelas->delete();

        return redirect()->route('superadmin.kelasIndex')->with('success', 'Kelas berhasil dihapus');
    }


}

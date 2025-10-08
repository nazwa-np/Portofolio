<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    // Menampilkan halaman kelola pengguna
    public function index()
    {
        $users = Dosen::all();
        return view('manage-users', compact('users'));
    }

    // Menampilkan halaman update user
    public function showUpdateUserPage()
    {
        $users = Dosen::all();
        return view('update-users', compact('users'));
    }

    // Menambahkan pengguna baru ke database dosen
    public function addUser(Request $request)
    {
        $validated = $request->validate([
            'nidn' => 'required',
            'nm_sdm' => 'required',
            'id_ikatan_kerja' => 'required',
            'npsn' => 'required',
            'nama_pt' => 'required',
            'kode_prodi' => 'required',
            'prodi' => 'required',
            'id_jabatan' => 'required',
            'id_gol' => 'required'
        ]);

        Dosen::create($validated);

        return redirect()->route('manage.users')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    // Mengupdate data pengguna berdasarkan nidn
    public function updateUser(Request $request, $nidn)
    {
        $validated = $request->validate([
            'nm_sdm' => 'required',
            'nama_pt' => 'nullable'
        ]);

        // Cari dosen berdasarkan nidn
        $dosen = Dosen::where('nidn', $nidn)->firstOrFail();

        // Perbarui data dosen
        $dosen->update($validated);

        return redirect()->route('update-users')->with('success', 'Data berhasil diperbarui.');
    }

    // Menghapus pengguna berdasarkan nidn
    public function deleteUser($nidn)
    {
        $dosen = Dosen::where('nidn', $nidn)->firstOrFail();
        $dosen->delete();

        return redirect()->route('update-users')->with('success', 'Data berhasil dihapus.');
    }

    public function searchUsers(Request $request)
    {
        $search = $request->input('search'); // Get the search query input

        // Build the query
        $query = Dosen::query();

        if ($search) {
            $query->where(function($query) use ($search) {
                $query->where('nidn', 'like', '%' . $search . '%')
                    ->orWhere('nm_sdm', 'like', '%' . $search . '%')
                    ->orWhere('nama_pt', 'like', '%' . $search . '%');
            });
        }

        // Get the filtered users
        $users = $query->get();

        return view('update-users', compact('users'));
    }

    
}


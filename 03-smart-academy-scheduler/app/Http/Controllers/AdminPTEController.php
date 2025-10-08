<?php

namespace App\Http\Controllers;

use App\Models\Admin_pte;
use App\Models\SaveDataPTE;
use Illuminate\Http\Request;

class AdminPTEController extends Controller
{
    public function index3()
    {
        $data_pte = Admin_pte::all();
        return view('adminpte.index3', compact('data_pte'));
    }

    public function show($id)
    {
        $data = Admin_pte::where('id', $id)->firstOrFail();
        return view('adminpte.show', compact('data'));
    }

    public function verifikasiMassal(Request $request)
    {
        $pilihan = $request->input('pilihan', []);
    
        if (empty($pilihan)) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }
    
        $dataTerpilih = Admin_pte::whereIn('id', $pilihan)->get();
    
        foreach ($dataTerpilih as $item) {
            // Cek apakah data dengan kolom-kolom sama sudah ada
            $isDuplicate = SaveDataPTE::where([
                'kode_seksi'  => $item->kode_seksi,
                'kode_mk'     => $item->kode_mk,
                'matkul'      => $item->matkul,
                'dosen'       => $item->dosen,
                'semester'    => $item->semester,
                'sks_teori'   => $item->sks_teori,
                'sks_praktek' => $item->sks_praktek,
                'sks_lapangan' => $item->sks_lapangan,
                'total_sks'   => $item->total_sks,
                'group'       => $item->group,
                'perkuliahan' => $item->perkuliahan,
                'prodi'        => 'PTE',
            ])->exists();
    
            if (!$isDuplicate) {
                SaveDataPTE::create([
                    'kode_seksi'   => $item->kode_seksi,
                    'kode_mk'      => $item->kode_mk,
                    'matkul'       => $item->matkul,
                    'dosen'        => $item->dosen,
                    'semester'     => $item->semester,
                    'sks_teori'    => $item->sks_teori,
                    'sks_praktek'  => $item->sks_praktek,
                    'sks_lapangan' => $item->sks_lapangan,
                    'total_sks'    => $item->total_sks,
                    'group'        => $item->group,
                    'perkuliahan'  => $item->perkuliahan,
                    'prodi'        => 'PTE',
                ]);
            }
        }
    
        return redirect()->route('adminpte.save_datapte')
            ->with('success', 'Data berhasil disimpan!')
            ->with('redirect_url', route('adminpte.save_datapte'));
    }
    
    public function saveDatapte()
    {
        // Ambil data yang sudah disimpan di database
        $data_pte = SaveDataPTE::all();
        return view('adminpte.save_datapte', compact('data_pte'));
    }

    public function create()
    {
        return view('adminpte.insert'); // form kosong untuk create
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_seksi'  => 'required|string|max:50',
            'kode_mk'     => 'required|string|max:50',
            'matkul'      => 'required|string|max:255',
            'dosen'       => 'required|string|max:255',
            'semester'    => 'required|integer|min:1',
            'sks_teori'   => 'required|integer|min:0',
            'sks_praktek' => 'required|integer|min:0',
            'sks_lapangan' => 'required|integer|min:0',
            'total_sks'   => 'required|integer|min:0',
            'group'       => 'required|string|max:10',
            'perkuliahan' => 'required|string|max:50',
        ]);

        Admin_pte::create($validated);

        // Redirect ke halaman form dan kirimkan session success
        return redirect()->route('adminpte.insert')->with('success', 'Data berhasil disimpan');
    }


    public function edit()
    {
        $data_pte = Admin_pte::all();
        return view('adminpte.edit', compact('data_pte'));
    }

    public function formUpdate($id)
    {
        $data = Admin_pte::findOrFail($id);
        return view('adminpte.update', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Admin_pte::findOrFail($id);
        $data->update($request->all());

        return redirect()->route('adminpte.edit', ['id' => $id])->with('success', 'Data berhasil diperbarui');
    }
    public function destroy($id)
    {
        $item = Admin_pte::findOrFail($id);
        $item->delete();

        return redirect()->route('adminpte.edit', ['id' => $id])->with('success', 'Data berhasil dihapus');
    }
}

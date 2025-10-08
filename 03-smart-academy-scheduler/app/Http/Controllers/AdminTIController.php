<?php

namespace App\Http\Controllers;

use App\Models\Admin_ti;
use App\Models\SaveDataTI;
use Illuminate\Http\Request;

class AdminTIController extends Controller
{
    public function index()
    {
        $data_ti = Admin_ti::all();
        return view('adminti.index1', compact('data_ti'));
    }

    public function show($id)
    {
        $data = Admin_ti::where('id', $id)->firstOrFail();
        return view('adminti.show', compact('data'));
    }

    public function verifikasiMassal(Request $request)
    {
        $pilihan = $request->input('pilihan', []);

        if (empty($pilihan)) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        $dataTerpilih = Admin_ti::whereIn('id', $pilihan)->get();

        foreach ($dataTerpilih as $item) {
            $isDuplicate = SaveDataTI::where([
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
                'prodi'        => 'TI', // Pastikan prodi juga dicek agar tidak double
            ])->exists();

            if (!$isDuplicate) {
                SaveDataTI::create([
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
                    'prodi'        => 'TI', // Set kolom prodi otomatis ke 'ti'
                ]);
            }
        }

        return redirect()->route('adminti.save_datati')
            ->with('success', 'Data berhasil disimpan untuk Prodi TI!')
            ->with('redirect_url', route('adminti.save_datati'));
    }

    
    public function saveDatati()
    {

        $data_ti = SaveDataTI::all();
        return view('adminti.save_datati', compact('data_ti'));
    }

    public function create()
    {
        return view('adminti.insert'); // form kosong untuk create
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

        Admin_ti::create($validated);


        return redirect()->route('adminti.insert')->with('success', 'Data berhasil disimpan');
    }

    public function resetData()
    {
        SaveDataTI::truncate(); // atau DataTI::delete();
        return redirect()->back()->with('success', 'Data berhasil direset.');
    }


    public function edit()
    {
        $data_ti = Admin_ti::all();
        return view('adminti.edit', compact('data_ti'));
    }

    public function formUpdate($id)
    {
        $data = Admin_ti::findOrFail($id);
        return view('adminti.update', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Admin_ti::findOrFail($id);
        $data->update($request->all());

        return redirect()->route('adminti.edit', ['id' => $id])->with('success', 'Data berhasil diperbarui');
    }
    public function destroy($id)
    {
        $item = Admin_ti::findOrFail($id);
        $item->delete();

        return redirect()->route('adminti.edit', ['id' => $id])->with('success', 'Data berhasil dihapus');
    }
}

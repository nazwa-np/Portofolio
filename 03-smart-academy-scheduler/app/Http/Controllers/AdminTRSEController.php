<?php

namespace App\Http\Controllers;

use App\Models\Admin_trse;
use App\Models\SaveDataTRSE;
use Illuminate\Http\Request;

class AdminTRSEController extends Controller
{
    public function index4()
    {
        $data_trse = Admin_trse::all();
        return view('admintrse.index4', compact('data_trse'));
    }

    public function show($id)
    {
        $data = Admin_trse::where('id', $id)->firstOrFail();
        return view('admintrse.show', compact('data'));
    }

    public function verifikasiMassal(Request $request)
    {
        $pilihan = $request->input('pilihan', []);
    
        if (empty($pilihan)) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }
    
        $dataTerpilih = Admin_trse::whereIn('id', $pilihan)->get();
    
        foreach ($dataTerpilih as $item) {

            $isDuplicate = SaveDataTRSE::where([
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
                'prodi'       => 'TRSE',
            ])->exists();
    
            if (!$isDuplicate) {
                SaveDataTRSE::create([
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
                    'prodi'        => 'TRSE',
                ]);
            }
        }
    
        return redirect()->route('admintrse.save_datatrse')
            ->with('success', 'Data berhasil disimpan!')
            ->with('redirect_url', route('admintrse.save_datatrse'));
    }
    
    public function SaveDataTRSE()
    {

        $data_trse = SaveDataTRSE::all();
        return view('admintrse.save_datatrse', compact('data_trse'));
    }

    public function create()
    {
        return view('admintrse.insert'); // form kosong untuk create
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

        Admin_trse::create($validated);


        return redirect()->route('admintrse.insert')->with('success', 'Data berhasil disimpan');
    }


    public function edit()
    {
        $data_trse = Admin_trse::all();
        return view('admintrse.edit', compact('data_trse'));
    }

    public function formUpdate($id)
    {
        $data = Admin_trse::findOrFail($id);
        return view('admintrse.update', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Admin_trse::findOrFail($id);
        $data->update($request->all());

        return redirect()->route('admintrse.edit', ['id' => $id])->with('success', 'Data berhasil diperbarui');
    }
    public function destroy($id)
    {
        $item = Admin_trse::findOrFail($id);
        $item->delete();

        return redirect()->route('admintrse.edit', ['id' => $id])->with('success', 'Data berhasil dihapus');
    }
}

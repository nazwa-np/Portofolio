<?php

namespace App\Http\Controllers;

use App\Models\Admin_pti;
use App\Models\SaveDataPTI;
use Illuminate\Http\Request;

class AdminPTIController extends Controller
{
    public function index2()
    {
        $data_pti = Admin_pti::all();
        return view('adminpti.index2', compact('data_pti'));
    }

    public function show($id)
    {
        $data = Admin_pti::where('id', $id)->firstOrFail();
        return view('adminpti.show', compact('data'));
    }

    public function verifikasiMassal(Request $request)
    {
        $pilihan = $request->input('pilihan', []);
    
        if (empty($pilihan)) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }
    
        $dataTerpilih = Admin_pti::whereIn('id', $pilihan)->get();
    
        foreach ($dataTerpilih as $item) {
            // Cek apakah data dengan kolom-kolom sama sudah ada
            $isDuplicate = SaveDataPTI::where([
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
                'prodi'       => 'PTI',
            ])->exists();
    
            if (!$isDuplicate) {
                SaveDataPTI::create([
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
                    'prodi'        => 'PTI',
                ]);
            }
        }
    
    return redirect()->route('adminpti.save_datapti')
    ->with('success', 'Data berhasil disimpan untuk Prodi PTI!')
    ->with('redirect_url', route('adminpti.save_datapti'));
    }

    public function saveDatapti()
    {
    $data_pti = SaveDataPTI::all();
    return view('adminpti.save_datapti', compact('data_pti'));
    }
    public function create()
    {
        return view('adminpti.insert'); // form kosong untuk create
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

        Admin_pti::create($validated);

        // Redirect ke halaman form dan kirimkan session success
        return redirect()->route('adminpti.insert')->with('success', 'Data berhasil disimpan');
    }


    public function edit()
    {
        $data_pti = Admin_pti::all();
        return view('adminpti.edit', compact('data_pti'));
    }

    public function formUpdate($id)
    {
        $data = Admin_pti::findOrFail($id);
        return view('adminpti.update', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Admin_pti::findOrFail($id);
        $data->update($request->all());

        return redirect()->route('adminpti.edit', ['id' => $id])->with('success', 'Data berhasil diperbarui');
    }
    public function destroy($id)
    {
        $item = Admin_pti::findOrFail($id);
        $item->delete();

        return redirect()->route('adminpti.edit', ['id' => $id])->with('success', 'Data berhasil dihapus');
    }
}

@extends('layouts.page_adminpte')

@section('page-title', 'Update Data')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-center align-items-center">
            <h5 class="mb-0.3" style="font-size: 1.9rem;">Update Data Prodi Informatika</h5>
          </div>
        <div class="card-body">
            <form method="POST" action="{{ route('adminpte.update', $data->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-2">
                    <label>Kode Seksi</label>
                    <input type="text" name="kode_seksi" class="form-control" value="{{ $data->kode_seksi }}" required>
                </div>
                <div class="mb-2">
                    <label>Kode MK</label>
                    <input type="text" name="kode_mk" class="form-control" value="{{ $data->kode_mk }}" required>
                </div>
                <div class="mb-2">
                    <label>Matakuliah</label>
                    <input type="text" name="matkul" class="form-control" value="{{ $data->matkul }}" required>
                </div>
                <div class="mb-2">
                    <label>Dosen</label>
                    <input type="text" name="dosen" class="form-control" value="{{ $data->dosen }}" required>
                </div>
                <div class="mb-2">
                    <label>Semester</label>
                    <input type="number" name="semester" class="form-control" value="{{ $data->semester }}" required>
                </div>
                <div class="mb-2">
                    <label>SKS Teori</label>
                    <input type="number" name="sks_teori" class="form-control" value="{{ $data->sks_teori }}" required>
                </div>
                <div class="mb-2">
                    <label>SKS Praktik</label>
                    <input type="number" name="sks_praktek" class="form-control" value="{{ $data->sks_praktek }}" required>
                </div>
                <div class="mb-2">
                    <label>SKS Lapangan</label>
                    <input type="number" name="sks_lapangan" class="form-control" value="{{ $data->sks_lapangan }}" required>
                </div>
                <div class="mb-2">
                    <label>Total SKS</label>
                    <input type="number" name="total_sks" class="form-control" value="{{ $data->total_sks }}" required>
                </div>
                <div class="mb-2">
                    <label>Group</label>
                    <input type="text" name="group" class="form-control" value="{{ $data->group }}" required>
                </div>
                <div class="mb-2">
                    <label>Perkuliahan</label>
                    <input type="text" name="perkuliahan" class="form-control" value="{{ $data->perkuliahan }}" required>
                </div>
                <div class="mt-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('adminpte.edit') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Update Data</button>
                </div>                
            </form>
        </div>
    </div>
</div>
@endsection

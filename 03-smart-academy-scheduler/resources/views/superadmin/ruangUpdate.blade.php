@extends('layouts.page_superadmin')

@section('page-title', 'Update Data Ruangan')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-center align-items-center">
            <h5 class="mb-0" style="font-size: 1.9rem;">Update Data Ruangan</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('superadmin.ruangUpdate', $data->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Nama Ruang</label>
                    <input type="text" name="lokal" class="form-control" value="{{ $data->lokal }}" required>
                </div>
                <div class="mb-3">
                    <label>Jenis Ruang</label>
                    <input type="text" name="jenis_kelas" class="form-control" value="{{ $data->jenis_kelas }}" required>
                </div>
                <div class="mb-3">
                    <label>Kapasitas</label>
                    <input type="text" name="kapasitas" class="form-control" value="{{ $data->kapasitas }}" required>
                </div>
                <div class="mb-3">
                    <label>Perkuliahan</label>
                    <input type="text" name="perkuliahan" class="form-control" value="{{ $data->perkuliahan }}" required>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


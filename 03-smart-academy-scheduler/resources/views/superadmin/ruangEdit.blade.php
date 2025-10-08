@extends('layouts.page_superadmin')
@section('page-title', 'Edit Ruangan')

@section('content')
<div class="container-fluid py-4">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-header">
          <h5>{{ isset($ruang_kelas) ? 'Edit Ruangan' : 'Tambah Ruangan' }}</h5>
        </div>
        <div class="card-body">
          <form action="{{ isset($ruang_kelas) 
                ? route('superadmin.ruangUpdate', $ruang_kelas->id) 
                : route('superadmin.ruangStore') }}"
                method="POST">
            @csrf
            @if(isset($ruang_kelas))
              @method('PUT')
            @endif

            <div class="mb-3">
              <label class="form-label">Ruang Kelas</label>
              <input type="text" name="lokal" class="form-control"
                     value="{{ old('lokal', $ruang_kelas->lokal ?? '') }}" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Jenis Ruang</label>
              <input type="text" name="jenis_kelas" class="form-control"
                     value="{{ old('jenis_kelas', $ruang_kelas->jenis_kelas ?? '') }}" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Kapasitas</label>
              <input type="text" name="kapasitas" class="form-control"
                     value="{{ old('kapasitas', $ruang_kelas->kapasitas ?? '') }}" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Kampus</label>
              <input type="text" name="perkuliahan" class="form-control"
                     value="{{ old('perkuliahan', $ruang_kelas->perkuliahan ?? '') }}" required>
            </div>
            <button type="submit" class="btn btn-success">
              {{ isset($ruang_kelas) ? 'Update' : 'Simpan' }}
            </button>
            <a href="{{ route('superadmin.ruangIndex') }}" class="btn btn-secondary">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

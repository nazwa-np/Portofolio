@extends('layouts.app')

@section('page-title', 'Rekap Data')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow p-4" style="width: 100%; max-width: 900px;">
        <h4 class="text-center mb-4">Form Rekap Data</h4>

        <form id="verificationForm" action="{{ route('layanan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="nidn">NIDN</label>
                <input type="text" class="form-control" id="nidn" name="nidn" value="{{ $data['nidn'] }}" readonly>
            </div>
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ $data['nama'] }}" readonly>
            </div>
            <div class="form-group">
                <label for="nomor_sertifikat">Nomor Sertifikat</label>
                <input type="text" class="form-control" id="nomor_sertifikat" name="nomor_sertifikat" value="{{ $data['nomor_sertifikat'] }}" readonly>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <input type="text" class="form-control" id="status" name="status" value="{{ $data['status'] }}" readonly>
            </div>
            <div class="form-group">
                <label for="kode_pt">Kode PT</label>
                <input type="text" class="form-control" id="kode_pt" name="kode_pt" value="{{ $data['kode_pt'] }}" readonly>
            </div>
            <div class="form-group">
                <label for="nama_pt">Nama PT</label>
                <input type="text" class="form-control" id="nama_pt" name="nama_pt" value="{{ $data['nama_pt'] }}" readonly>
            </div>
            <div class="form-group">
                <label for="kode_prodi">Kode Prodi</label>
                <input type="text" class="form-control" id="kode_prodi" name="kode_prodi" value="{{ $data['kode_prodi'] }}" readonly>
            </div>
            <div class="form-group">
                <label for="nama_prodi">Nama Prodi</label>
                <input type="text" class="form-control" id="nama_prodi" name="nama_prodi" value="{{ $data['nama_prodi'] }}" readonly>
            </div>
            <div class="form-group">
                <label for="jab_fungsional">Jabatan Fungsional</label>
                <input type="text" class="form-control" id="jabatan_fungsional" name="jabatan_fungsional" value="{{ $data->jabatan_fungsional ?? 'Data tidak ditemukan' }}" readonly>
            </div>            
            <div class="form-group">
                <label for="golongan_pangkat">Golongan Pangkat</label>
                <input type="text" class="form-control" id="golongan_pangkat" name="golongan_pangkat" value="{{ $data['golongan_pangkat'] }}" readonly>
            </div>
            <div class="mb-3">
                @if($data->upload_file)
                    <!-- Tombol Download PDF -->
                    <a href="{{ route('admin.downloadPDF', $data->nidn) }}" class="btn btn-secondary">Download PDF</a>
                    
                    <!-- Tombol Lihat PDF -->
                    <a href="{{ route('admin.viewPDF', $data->nidn) }}" target="_blank" class="btn btn-secondary">Lihat PDF</a>
                @else
                    <p>File PDF tidak tersedia.</p>
                @endif
            </div>
        
        </form>
    </div>
</div>


@endsection
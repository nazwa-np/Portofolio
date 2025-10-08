@extends('layouts.app')

@section('page-title', 'Form Layanan')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow p-4" style="width: 100%; max-width: 900px;">
        <h4 class="text-center mb-4">Form Laporan Kinerja Dosen</h4>
        
        <!-- Notifikasi untuk SweetAlert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif
     
        @if(session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        <form action="{{ route('layanan.store') }}" method="POST" enctype="multipart/form-data">
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
                <input type="text" class="form-control" id="jab_fungsional" name="jab_fungsional" value="{{ $data['jab_fungsional'] }}" readonly>
            </div>
            <div class="form-group">
                <label for="golongan_pangkat">Golongan Pangkat</label>
                <input type="text" class="form-control" id="golongan_pangkat" name="golongan_pangkat" value="{{ $data['golongan_pangkat'] }}" readonly>
            </div>
            <div class="form-group">
                <label for="upload_file">Upload PDF</label>
                <input type="file" name="upload_file" id="upload_file" class="form-control" accept="application/pdf" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Submit</button>
        </form>            
    </div>
</div>
@endsection
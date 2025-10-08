@extends('layouts.page')

@section('page-title', 'Detail Layanan')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow p-4" style="width: 100%; max-width: 900px;">
        <h4 class="text-center mb-4">Form Layanan LKPD</h4>

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
            
            <!-- Tombol untuk Mengirim Form -->
            <div class="form-group mt-4">
                <button type="button" class="btn btn-primary" style="width: 100%;" onclick="openModal()">Lakukan Verifikasi Data</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal untuk Konfirmasi Verifikasi -->
<div class="modal fade" id="verificationModal" tabindex="-1" role="dialog" aria-labelledby="verificationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verificationModalLabel">Konfirmasi Verifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin melakukan verifikasi? 
                <!-- Form untuk Verifikasi -->
                <form action="{{ route('admin.verifikasi') }}" method="POST" id="modalVerificationForm">
                    @csrf
                    <input type="hidden" name="nidn" value="{{ $data['nidn'] }}"> <!-- Menambahkan input tersembunyi untuk NIDN -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success square-button" onclick="submitForm('approved')">Setujui</button>
                <button type="button" class="btn btn-danger square-button" onclick="submitForm('rejected')">Tolak</button>
            </div>
        </div>
    </div>
</div>

<!-- Sertakan SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function openModal() {
        $('#verificationModal').modal('show');
    }

    function submitForm(result) {
        var form = document.getElementById('modalVerificationForm'); // Menggunakan ID baru
        const inputResult = document.createElement('input');
        inputResult.type = 'hidden';
        inputResult.name = 'verifikasi'; // Menetapkan input untuk verifikasi
        inputResult.value = result; // Set value to either 'approved' or 'rejected'
        form.appendChild(inputResult); // Menambahkan input ke form

        // Show notification before submitting the form
        Swal.fire({
            title: result === 'approved' ? 'Sukses!' : 'Gagal!',
            text: result === 'approved' ? 'Data berhasil Diverifikasi.' : 'Data gagal Diverifikasi.',
            icon: result === 'approved' ? 'success' : 'error',
            confirmButtonText: 'OK'
        }).then((res) => {
            if (res.isConfirmed) {
                form.submit(); // Submit the form after notification
            }
        });
    }
</script>

<style>
    /* Custom styles for the buttons */
    .square-button {
        width: 80px;  /* Set width for square shape */
        height: 40px; /* Set height for square shape */
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 13px; /* Adjust font size as needed */
        border-radius: 5px; /* Optional: add border-radius for rounded corners */
    }
</style>

@endsection
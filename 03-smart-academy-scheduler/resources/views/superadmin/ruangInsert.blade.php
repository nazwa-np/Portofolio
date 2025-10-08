@extends('layouts.page_superadmin')

@section('page-title', 'Tambah Data Ruangan')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-center align-items-center">
            <h5 class="mb-0.3" style="font-size: 1.9rem;">Tambah Data Ruangan</h5>
          </div>
        <div class="card-body">
            <form method="POST" action="{{ route('superadmin.ruangStore') }}">
                @csrf
                <div class="mb-2">
                    <label>Nama Ruang</label>
                    <input type="text" name="lokal" class="form-control" value="{{ old('lokal') }}" required>
                </div>
                <div class="mb-2">
                    <label for="jenis_kelas">Jenis Ruang</label>
                    <select name="jenis_kelas" class="form-control" required>
                        <option value="">-- Pilih Jenis Ruang --</option>
                        <option value="teori" {{ old('jenis_kelas') == 'teori' ? 'selected' : '' }}>Teori</option>
                        <option value="praktek" {{ old('jenis_kelas') == 'praktek' ? 'selected' : '' }}>Praktek</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label>Kapasitas</label>
                    <input type="text" name="kapasitas" class="form-control" value="{{ old('kapasitas') }}" required>
                </div>
                <div class="mb-2">
                    <label>Perkuliahan</label>
                    <input type="text" name="perkuliahan" class="form-control" value="{{ old('perkuliahan') }}" required>
                </div>
                <div class="mt-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('superadmin.ruangIndex') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Konfirmasi hapus data
    document.querySelectorAll('.form-delete').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Notifikasi success
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 2000
    });
    @endif
</script>

@endsection

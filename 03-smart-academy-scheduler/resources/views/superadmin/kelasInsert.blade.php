@extends('layouts.page_superadmin')

@section('page-title', 'Tambah Data Kelas')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-center align-items-center">
            <h5 class="mb-0.3" style="font-size: 1.9rem;">Tambah Data Kelas</h5>
          </div>
        <div class="card-body">
            <form method="POST" action="{{ route('superadmin.kelasStore') }}">
                @csrf
                <div class="mb-2">
                    <label>Kode Seksi</label>
                    <select name="kode_seksi" id="kode_seksi" class="form-control" required>
                        <option value="">-- Pilih Kode Seksi --</option>
                        @foreach($kelas as $seksi)
                            <option value="{{ $seksi->kode_seksi }}">{{ $seksi->kode_seksi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <label>Kode Matakuliah</label>
                    <input type="text" id="kode_mk" name="kode_mk" class="form-control" required readonly>
                </div>
                <div class="mb-2">
                    <label>Prodi</label>
                    <input type="text" id="prodi" name="prodi" class="form-control" required readonly>
                </div>
                <div class="mb-2">
                    <label>Group</label>
                    <input type="text" id="group" name="group" class="form-control" required readonly>
                </div>
                <div class="mb-2">
                    <label>Jumlah Mahasiswa</label>
                    <input type="text" name="jml_mhs" class="form-control" value="{{ old('jml_mhs') }}" required>
                </div>
                <div class="mt-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('superadmin.kelasIndex') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('kode_seksi').addEventListener('change', function () {
        const kodeSeksi = this.value;
        if (!kodeSeksi) return;

        fetch(`/get-kode-seksi/${kodeSeksi}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.error,
                    });
                    document.getElementById('kode_mk').value = '';
                    document.getElementById('prodi').value = '';
                    document.getElementById('group').value = '';
                } else {
                    document.getElementById('kode_mk').value = data.kode_mk;
                    document.getElementById('prodi').value = data.prodi;
                    document.getElementById('group').value = data.group;
                }
            });
    });
</script>


<script>
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

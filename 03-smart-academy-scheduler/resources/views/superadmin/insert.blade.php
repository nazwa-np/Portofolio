@extends('layouts.page_superadmin')

@section('page-title', 'Tambah Data')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-center align-items-center">
            <h5 class="mb-0.3" style="font-size: 1.9rem;">Tambah Data User</h5>
          </div>
        <div class="card-body">
            <form method="POST" action="{{ route('superadmin.store') }}">
                @csrf
                <div class="mb-2">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
                </div>
                <div class="mb-2">
                    <label>Password</label>
                    <input type="text" name="password" class="form-control" value="{{ old('password') }}" required>
                </div>
                <div class="mb-2">
                    <label>Role</label>
                    <input type="text" name="role" class="form-control" value="{{ old('role') }}" required>
                </div>
                <div class="mt-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('superadmin.index') }}" class="btn btn-secondary">Kembali</a>
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

@extends('layouts.page_superadmin')

@section('page-title', 'Tambah Data')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-center align-items-center">
            <h5 class="mb-0.3" style="font-size: 1.9rem;">Tambah Constraints</h5>
          </div>
            <div class="card-body">
                <form method="POST" action="{{ route('superadmin.constraints.ruangan_store') }}">
                    @csrf
                    <div class="mb-2">
                    <label>Kode MK</label>
                    <select name="kode_mk" id="kode_mk" class="form-control" required>
                        <option value="">-- Pilih Kode MK --</option>
                        @foreach($kodeMks as $item)
                            <option value="{{ $item->kode_mk }}"
                                data-matkul="{{ $item->matkul }}"
                                data-prodi="{{ $item->prodi }}">
                                {{ $item->kode_mk }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-2">
                    <label>Matakuliah</label>
                    <input type="text" name="matkul" id="matkul" class="form-control" readonly required>
                </div>

                <div class="mb-2">
                    <label>Prodi</label>
                    <input type="text" name="prodi" id="prodi" class="form-control" readonly required>
                </div>

                <div class="mb-2">
                <label>Ruangan</label>
                <select name="lokal" id="lokal" class="form-control" required>
                    <option value="">-- Pilih Ruangan --</option>
                    @foreach($ruangans as $ruangan)
                        <option value="{{ $ruangan->lokal }}"
                            data-jenis="{{ $ruangan->jenis_kelas}}"
                            data-kapasitas="{{ $ruangan->kapasitas }}"
                            data-perkuliahan="{{ $ruangan->perkuliahan }}">
                            {{ $ruangan->lokal }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-2">
                <label>Jenis Ruangan</label>
                <input type="text" name="jenis_kelas" id="jenis_kelas" class="form-control" readonly required>
            </div>
            <div class="mb-2">
                <label>Kapasitas</label>
                <input type="text" name="kapasitas" id="kapasitas" class="form-control" readonly required>
            </div>
            <div class="mb-2">
                <label>Perkuliahan</label>
                <input type="text" name="perkuliahan" id="perkuliahan" class="form-control" readonly required>
            </div>

                <div class="mt-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('superadmin.constraints.ruangan') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('kode_mk').addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const matkul = selected.getAttribute('data-matkul');
        const prodi = selected.getAttribute('data-prodi');

        document.getElementById('matkul').value = matkul || '';
        document.getElementById('prodi').value = prodi || '';
    });
</script>

<script>
    document.getElementById('lokal').addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const jenis = selected.getAttribute('data-jenis');
        const kapasitas = selected.getAttribute('data-kapasitas');

        document.getElementById('jenis_kelas').value = jenis || '';
        document.getElementById('kapasitas').value = kapasitas || '';
    });
</script>


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

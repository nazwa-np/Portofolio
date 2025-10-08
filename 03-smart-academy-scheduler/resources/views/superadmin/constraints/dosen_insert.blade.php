@extends('layouts.page_superadmin')

@section('content')

<div class="container py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-center align-items-center">
            <h5 class="mb-0.3" style="font-size: 1.9rem;">Tambah Data Constraints</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('superadmin.constraints.dosen_store') }}">
                @csrf
                {{-- Pilih Dosen --}}
                <div class="form-group">
                    <label for="dosen">Nama Dosen</label>
                    <select name="dosen" id="dosen" class="form-control @error('dosen') is-invalid @enderror" required>
                        <option value="">-- Pilih Dosen --</option>
                        @foreach($dosens as $item)
                            <option value="{{ $item->dosen }}" {{ old('dosen') == $item->dosen ? 'selected' : '' }}>
                                {{ $item->dosen }}
                            </option>
                        @endforeach
                    </select>
                    @error('dosen')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Pilih Hari --}}
                <div class="form-group">
                    <label for="hari">Hari</label>
                    <select name="hari" id="hari" class="form-control @error('hari') is-invalid @enderror" required>
                        <option value="">-- Pilih Hari --</option>
                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                            <option value="{{ $hari }}" {{ old('hari') == $hari ? 'selected' : '' }}>
                                {{ $hari }}
                            </option>
                        @endforeach
                    </select>
                    @error('hari')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Pilih Jam (Checkbox) --}}
                <div class="form-group">
                    <label>Jam ke-</label>
                    <div class="border p-3 rounded">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="selectAllJam" name="all_jam"
                                {{ in_array('ALL', old('jam_ke', [])) || count(old('jam_ke', [])) == 12 ? 'checked' : '' }}>
                            <label class="form-check-label font-weight-bold" for="selectAllJam">
                                ALL (Semua Jam)
                            </label>
                        </div>
                        
                        <div class="row">
                            @for($i = 1; $i <= 12; $i++)
                                <div class="col-md-2 col-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input jam-checkbox" type="checkbox" 
                                            name="jam_ke[]" value="{{ $i }}" id="jam{{ $i }}"
                                            {{ in_array($i, old('jam_ke', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="jam{{ $i }}">
                                            {{ $i }}
                                        </label>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                    @error('jam_ke')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Pilih Status --}}
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="Tidak Tersedia" {{ old('status') == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Dapat Hadir</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mt-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('superadmin.constraints.dosen') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan Kendala</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAll = document.getElementById('selectAllJam');
        const checkboxes = document.querySelectorAll('.jam-checkbox');

        // Saat tombol "ALL" dicentang, centang/uncentang semua jam
        selectAll.addEventListener('change', function () {
            checkboxes.forEach(cb => {
                cb.checked = this.checked;
            });
        });

        // Saat semua jam dicentang manual, aktifkan "ALL"
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                const allChecked = Array.from(checkboxes).every(c => c.checked);
                selectAll.checked = allChecked;
            });
        });

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
    });
</script>
@endsection

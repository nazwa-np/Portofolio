@extends('layouts.page_adminti')

@section('page-title', 'Data Yang Tersimpan')

@section('content')

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-center align-items-center">
          <h5 class="mb-0.3" style="font-size: 1.9rem;">Data Tersimpan</h5>
        </div>
        <div class="card-body px-2 py-2">
          <div class="table-responsive">
            <div class="mb-3 text-end px-3">
              <form action="{{ route('reset.save_data_ti') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mereset semua data?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                  <i class="fa-solid fa-trash"></i> Reset Data
                </button>
              </form>
            </div>
            <table id="datatable-ti"
              class="table table-striped table-hover table-bordered align-middle text-center"
              style="font-size: 0.8rem; width: 100%;">
              <thead class="text-uppercase">
                <tr>
                  <th>No</th>
                  <th>Kode Seksi</th>
                  <th>Kode Mk</th>
                  <th>Matakuliah</th>
                  <th>Dosen</th>
                  <th>Semester</th>
                  <th>SKS Teori</th>
                  <th>SKS Praktek</th>
                  <th>SKS Lapangan</th>
                  <th>Total SKS</th>
                  <th>Group</th>
                  <th>Perkuliahan</th>
                </tr>
              </thead>
              <tbody>
                @forelse($data_ti as $index => $item)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $item->kode_seksi }}</td>
                  <td>{{ $item->kode_mk }}</td>
                  <td class="text-start">{{ $item->matkul }}</td>
                  <td class="text-start">{{ $item->dosen }}</td>
                  <td>{{ $item->semester }}</td>
                  <td>{{ $item->sks_teori }}</td>
                  <td>{{ $item->sks_praktek }}</td>
                  <td>{{ $item->sks_lapangan }}</td>
                  <td>{{ $item->total_sks }}</td>
                  <td>{{ $item->group }}</td>
                  <td>{{ $item->perkuliahan }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="10" class="text-center">Belum ada data yang disimpan.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Konfirmasi hapus data
    document.querySelectorAll('.resetData').forEach(form => {
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


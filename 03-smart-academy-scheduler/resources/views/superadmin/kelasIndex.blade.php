@extends('layouts.page_superadmin')
@section('page-title', 'Data Kelas')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4 shadow-sm">
        <div class="card-header text-center">
          <h5 class="mb-0" style="font-size: 1.9rem;">Data Kelas</h5>
        </div>
        <div class="card-body px-3 py-3">
          <div class="mb-3 text-end">
            <a href="{{ route('superadmin.kelasCreate') }}" class="btn btn-primary">
              <i class="fas fa-plus"></i> Tambah Kelas
            </a>
          <div class="card-body px-2 py-2">
            <div class="table-responsive">
              <table id="datatable-ti"
                     class="table table-striped table-hover table-bordered align-middle text-center"
                     style="font-size: 0.8rem; width: 100%;">
                <thead class="text-uppercase">
                  <tr class="text-center">
                  <th style="width: 5%;">No</th>
                  <th>Kode Seksi</th>
                  <th>Kode Matakuliah</th>
                  <th>Prodi</th>
                  <th>Group</th>
                  <th>Jumlah Mahasiswa</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($kelas as $i => $item)
                  <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->kode_seksi }}</td>
                    <td>{{ isset($item->kode_mk) ? $item->kode_mk : '' }}</td>
                    <td>{{ isset($item->prodi) ? $item->prodi : '' }}</td>
                    <td>{{ isset($item->group) ? $item->group : '' }}</td>
                    <td>{{ isset($item->jml_mhs) ? $item->jml_mhs : 0 }}</td>
                    <td>
                      <form action="{{ route('superadmin.kelasDestroy', $item->id) }}"
                            method="POST"
                            class="d-inline form-delete">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                          <i class="fas fa-trash"></i>
                        </button>
                      </form>
                    </td>                               
                  </tr>
                @endforeach
              </tbody>
            </table>
            @if($kelas->isEmpty())
              <p class="text-center text-muted my-3">Tidak ada data kelas.</p>
            @endif
          </div>
        </div>
      </div>
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
      }).then(result => {
        if (result.isConfirmed) form.submit();
      });
    });
  });

  // Notifikasi success update / delete
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
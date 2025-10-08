@extends('layouts.page_superadmin')
@section('page-title', 'Data Ruang Kelas')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4 shadow-sm">
        <div class="card-header text-center">
          <h5 class="mb-0" style="font-size: 1.9rem;">Data Ruang Kelas</h5>
        </div>
        <div class="card-body px-3 py-3">
          <div class="mb-3 text-end">
            <a href="{{ route('superadmin.ruangCreate') }}" class="btn btn-primary">
              <i class="fas fa-plus"></i> Tambah Ruangan
            </a>
          </div>
         <div class="card-body px-2 py-2">
            <div class="table-responsive">
              <table id="datatable-ti"
                     class="table table-striped table-hover table-bordered align-middle text-center"
                     style="font-size: 0.8rem; width: 100%;">
                <thead class="text-uppercase">
                <tr>
                  <th style="width: 5%;">No</th>
                  <th>Nama Ruang</th>
                  <th>Jenis Ruang</th>
                  <th>Kapasitas</th>
                  <th>Kampus</th>
                  <th style="width: 15%;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($ruang_kelas as $i => $itm)
                  <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $itm->lokal }}</td>
                    <td>{{ $itm->jenis_kelas }}</td>
                    <td>{{ $itm->kapasitas }}</td>
                    <td>{{ $itm->perkuliahan }}</td>
                    <td>
                      <a href="{{ route('superadmin.ruangEdit', $itm->id) }}" class="btn btn-sm btn-warning me-1">
                        <i class="fas fa-edit"></i>
                      </a>
                      <form action="{{ route('superadmin.ruangDestroy', $itm->id) }}"
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
            @if($ruang_kelas->isEmpty())
              <p class="text-center text-muted my-3">Tidak ada data user.</p>
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

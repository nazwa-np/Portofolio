@extends('layouts.page_superadmin')
@section('page-title', 'Data Constraints')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4 shadow-sm">
        <div class="card-header text-center">
          <h5 class="mb-0" style="font-size: 1.9rem;">Constraints Dosen</h5>
        </div>
        <div class="card-body px-3 py-3">
          <div class="mb-3 text-end">
            <a href="{{ route('superadmin.constraints.dosen_insert') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Constraint
            </a>
          </div>
          <div class="card-body px-2 py-2">
            <div class="table-responsive">
              <table id="datatable-ti"
                     class="table table-striped table-hover table-bordered align-middle text-center"
                     style="font-size: 0.8rem; width: 100%;">
                <thead class="text-uppercase">
                <tr>
                    <th>No</th>
                    <th>Dosen</th>
                    <th>Hari</th>
                    <th>Jam Ke</th>
                    <th>Status</th>
                    <th>Delete Data</th>
                </tr>
              </thead>
              <tbody>
                @foreach($constraints as $i => $itm)
                <tr>
                    <td>{{ $i+ 1 }}</td>
                    <td>{{ $itm->dosen }}</td>
                    <td>{{ $itm->hari }}</td>
                    <td>{{ $itm->jam_ke }}</td>
                    <td>
                      @if($itm->status === 'Tidak Tersedia')
                          <span class="text-custom-grey">Tidak Dapat Hadir</span>
                      @endif
                    </td>
                    <td>
                        <form action="{{ route('superadmin.constraints.dosen_delete', $itm->id) }}"
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
            @if($constraints->isEmpty())
              <p class="text-center text-muted my-3">Tidak ada data constraints.</p>
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
@extends('layouts.page_admintrse')

@section('page-title', 'Data Tersimpan')

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
                                        <th>SKS T</th>
                                        <th>SKS P</th>
                                        <th>SKS L</th>
                                        <th>Tot SKS</th>
                                        <th>Group</th>
                                        <th>Perkuliahan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data_trse as $i => $itm)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $itm->kode_seksi }}</td>
                                            <td>{{ $itm->kode_mk }}</td>
                                            <td class="text-start">{{ $itm->matkul }}</td>
                                            <td class="text-start">{{ $itm->dosen }}</td>
                                            <td>{{ $itm->semester }}</td>
                                            <td>{{ $itm->sks_teori }}</td>
                                            <td>{{ $itm->sks_praktek }}</td>
                                            <td>{{ $itm->sks_lapangan }}</td>
                                            <td>{{ $itm->total_sks }}</td>
                                            <td>{{ $itm->group }}</td>
                                            <td>{{ $itm->perkuliahan }}</td>
                                            <td>
                                                <a href="{{ route('admintrse.form_update', $itm->id) }}" class="btn btn-sm btn-warning me-1">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admintrse.destroy', $itm->id) }}" method="POST" class="d-inline form-delete">
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
                        </div>
                    </div>                  
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

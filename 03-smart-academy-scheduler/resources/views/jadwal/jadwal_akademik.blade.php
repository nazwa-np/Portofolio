@extends('layouts.page_superadmin')

@section('page-title', 'Jadwal Akademik')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4 shadow-sm">
        <div class="card-header text-center">
          <h5 class="mb-0" style="font-size: 1.9rem;">Jadwal Akademik</h5>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered table-hover align-middle text-center" style="font-size: 0.9rem;">
            <thead class="table-light text-uppercase">
              <tr>
                  <th>No</th>
                  <th>Kode Matkul</th>
                  <th>Matakuliah</th>
                  <th>Dosen</th>
                  <th>Hari</th>
                  <th>Jam Ke</th>
                  <th>Waktu</th>
                  <th>Lokal</th>
                  <th>SKS Teori</th>
                  <th>SKS Praktek</th>
                  <th>SKS Lapangan</th>
                  <th>Total SKS</th>
                  <th>Group</th>
                  <th>Semester</th>
                  <th>Prodi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($jadwal as $i => $item)
              <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->kode_mk }}</td>
                <td>{{ $item->matkul }}</td>
                <td>{{ $item->dosen }}</td>
                <td>{{ $item->hari }}</td>
                <td>{{ $item->jam_ke }}</td>
                <td>{{ $item->waktu }}</td>
                <td>{{ $item->lokal }}</td>
                <td>{{ $item->sks_teori }}</td>
                <td>{{ $item->sks_praktek }}</td>
                <td>{{ $item->sks_lapangan }}</td>
                <td>{{ $item->total_sks }}</td>
                <td>{{ $item->group }}</td>
                <td>{{ $item->semester }}</td>
                <td>{{ $item->prodi }}</td>
              </tr>
              @empty
              <tr>
                <td colspan="15" class="text-center text-muted">Tidak ada data jadwal.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

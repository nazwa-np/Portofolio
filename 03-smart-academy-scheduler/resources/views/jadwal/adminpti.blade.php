@extends('layouts.page_adminpti')

@section('page-title', 'Jadwal Akademik')

@section('content')

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4 shadow-sm">

        <div class="card-header d-flex justify-content-center align-items-center">
          <h5 class="mb-0" style="font-size: 1.9rem;">Jadwal Akademik</h5>
        </div>

        <div class="card-body py-2 px-4">
        <div class="d-flex justify-content-between align-items-center">
          @if ($jadwal->isEmpty())
            <div class="ms-auto">
              <form action="{{ route('jadwal.generate') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success btn-sm">
                  <i class="fa fa-cogs me-1"></i> Generate Jadwal
                </button>
              </form>
            </div>
          @else
            <div class="ms-auto d-flex">
              <form action="{{ route('jadwal.reset') }}" method="POST" class="me-2">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">
                  <i class="fa fa-refresh me-1"></i> Reset Jadwal
                </button>
              </form>

            </div>
          @endif
        </div>
      </div>

        <div class="card-body pt-0 px-2 pb-2">
          <div class="table-responsive">
            <table id="datatable-ti"
              class="table table-striped table-hover table-bordered align-middle text-center"
              style="font-size: 0.8rem; width: 100%;">
              <thead class="text-uppercase">
                <tr>
                  <th>No</th>
                  <th>Kode Seksi</th>
                  <th>Kode Matkul</th>
                  <th>Matakuliah</th>
                  <th>Dosen</th>
                  <th>Hari</th>
                  <th>Jam Ke</th>
                  <th>Waktu</th>
                  <th>Lokal</th>
                  <th>SKS T</th>
                  <th>SKS P</th>
                  <th>SKS L</th>
                  <th>Total SKS</th>
                  <th>Group</th>
                  <th>Semester</th>
                  <th>Prodi</th>
                  <th>Perkuliahan</th>
                </tr>
              </thead>
              <tbody>
                @forelse($jadwal as $i => $item)
                <tr>
                  <td>{{ $i + 1 }}</td>
                  <td>{{ $item->kode_seksi }}</td>
                  <td>{{ $item->kode_mk }}</td>
                  <td class="text-start">{{ $item->matkul }}</td>
                  <td class="text-start">{{ $item->dosen }}</td>
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
                  <td>{{ $item->perkuliahan }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="15" class="text-center text-muted">Belum ada data jadwal.</td>
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

@endsection

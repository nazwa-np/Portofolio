@extends('layouts.page_adminti')

@section('page-title', 'Data Informatika')

@section('content')

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <form id="form-pilih" action="{{ route('adminti.verifikasi-massal') }}" method="POST">
        @csrf
        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-white d-flex justify-content-center align-items-center">
            <h5 class="mb-0" style="font-size: 1.8rem;">Data Prodi Informatika</h5>
          </div>
          <div class="card-body px-2 py-2">
            <div class="table-responsive">
              <table id="datatable-ti"
                     class="table table-striped table-hover table-bordered align-middle text-center"
                     style="font-size: 0.8rem; width: 100%;">
                <thead class="text-uppercase">
                  <tr class="text-center">
                    <th><input type="checkbox" id="checkAll" /></th>
                    <th>No</th>
                    <th>Kode Seksi</th>
                    <th>Kode Mk</th>
                    <th>Matakuliah</th>
                    <th>Dosen</th>
                    <th>Semester</th>
                    <th>SKS T</th>
                    <th>SKS P</th>
                    <th>SKS L</th>
                    <th>Total SKS</th>
                    <th>Group</th>
                    <th>Perkuliahan</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($data_ti as $i => $item)
                  <tr>
                    <td><input type="checkbox" name="pilihan[]" value="{{ $item->id }}"></td>
                    <td>{{ $i + 1 }}</td>
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
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer bg-white text-end">
            <button type="button" id="btn-confirm" class="btn btn-success btn-sm">
              <i class="fa fa-save me-1"></i> Simpan Pilihan
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

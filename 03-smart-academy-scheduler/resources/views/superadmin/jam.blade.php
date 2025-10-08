@extends('layouts.page_superadmin')
@section('page-title', 'Data Hari')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4 shadow-sm">
        <div class="card-header text-center">
          <h5 class="mb-0" style="font-size: 1.9rem;">Data Waktu Perkuliahan</h5>
        </div>
        <div class="card-body px-3 py-3">
          <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center" style="font-size: 0.9rem;">
              <thead class="table-light text-uppercase">
                <tr>
                  <th>Jam Ke</th>
                  <th>Waktu Mulai</th>
                  <th>Waktu Selesai</th>
                </tr>
              </thead>
              <tbody>
                @foreach($jam as $i => $itm)
                  <tr>
                    <td>{{ $itm->jam_ke }}</td>
                    <td>{{ $itm->waktu_mulai }}</td>
                    <td>{{ $itm->waktu_selesai }}</td>                            
                  </tr>
                @endforeach
              </tbody>
            </table>
            @if($jam->isEmpty())
              <p class="text-center text-muted my-3">Tidak ada data waktu perkuliahan.</p>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@extends('layouts.page')

@section('page-title', 'Data Rejected')

@section('content')
<div class="container-fluid py-5">
    <div class="row">
        <div class="col-14">
            <div class="card mb-5">
                <div class="card-header pb-0">
                    <h4 class="mb-0">Data Rejected</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIDN</th>
                                    <th>Nama</th>
                                    <th>Tanggal Verifikasi</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @if($layanans->isEmpty())
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data yang ditolak.</td>
                                    </tr>
                                @else
                                    @foreach($layanans as $index => $layanan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $layanan->nidn }}</td>
                                        <td>{{ $layanan->nama }}</td>
                                        <td>{{ $layanan->updated_at->format('d F Y') }}</td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
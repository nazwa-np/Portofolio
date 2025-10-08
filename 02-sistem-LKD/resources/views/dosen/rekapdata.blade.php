@extends('layouts.app')

@section('page-title', 'Form Rekap Data')

@section('content')
<div class="container-fluid py-5">
    <div class="row">
        <div class="col-14">
            <div class="card mb-5">
                <div class="card-header pb-0">
                    <h4 class="mb-0">Rekap Data</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal Submit</th>
                                    <th>Status Verifikasi</th> 
                                    <th>Aksi</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @if($data->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data yang disetujui.</td>
                                    </tr>
                                @else
                                    @foreach($data as $item)
                                        <tr>
                                            <td>{{ $item->created_at->format('d F Y') }}</td>
                                            <td>{{ ucfirst($item->verifikasi) }}</td>
                                                                               
                                            <td>
                                                <a href="{{ route('dosen.tampildata', $item->nidn) }}" class="btn btn-info">View</a>
                                            </td>
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
@extends('layouts.page_superadmin')
@section('page-title', 'Daftar Constraints')

@section('content')
<div class="container-fluid py-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-header text-center">
          <h5 class="mb-0" style="font-size: 1.9rem;">Daftar Constraints</h5>
        </div>
        <div class="card-body">
          <div class="list-group text-center">
            <a href="{{ route('superadmin.constraints.dosen') }}" class="list-group-item list-group-item-action">
              <i class="fas fa-user-tie me-2"></i> Constraints Dosen
            </a>
            <a href="{{ route('superadmin.constraints.ruangan') }}" class="list-group-item list-group-item-action">
              <i class="fas fa-door-closed me-2"></i> Constraints Ruangan
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

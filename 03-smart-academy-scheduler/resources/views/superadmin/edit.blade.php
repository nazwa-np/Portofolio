@extends('layouts.page_superadmin')
@section('page-title', 'Form User')

@section('content')
<div class="container-fluid py-4">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-header">
          <h5>{{ isset($user) ? 'Edit User' : 'Tambah User' }}</h5>
        </div>
        <div class="card-body">
          <form action="{{ isset($user) 
                ? route('superadmin.update', $user->id) 
                : route('superadmin.store') }}"
                method="POST">
            @csrf
            @if(isset($user))
              @method('PUT')
            @endif

            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control"
                     value="{{ old('username', $user->username ?? '') }}" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control"
                     {{ isset($user) ? '' : 'required' }}>
              @if(isset($user))
                <small class="text-muted">Kosongkan jika tidak ingin mengganti password.</small>
              @endif
            </div>

            <button type="submit" class="btn btn-success">
              {{ isset($user) ? 'Update' : 'Simpan' }}
            </button>
            <a href="{{ route('superadmin.index') }}" class="btn btn-secondary">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

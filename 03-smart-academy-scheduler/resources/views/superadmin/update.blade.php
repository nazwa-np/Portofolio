@extends('layouts.page_superadmin')

@section('page-title', 'Update Data User')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-center align-items-center">
            <h5 class="mb-0" style="font-size: 1.9rem;">Update Data User</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('superadmin.updateUser', $data->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="{{ $data->username }}" required>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <div class="input-group">
                        <input type="password" id="password" name="matkul" class="form-control" value="{{ $data->password }}" required>
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                            <i class="fa fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Role</label>
                    <input type="text" name="role" class="form-control" value="{{ $data->role }}" required>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


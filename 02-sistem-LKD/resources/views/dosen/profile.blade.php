@extends('layouts.profiledosen')

@section('page-title', 'Form Layanan')

@section('content')

    <div class="card shadow-lg mx-4 card-profile-bottom">
      <div class="card-body p-3">
        <div class="row gx-4">
          <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
              <img src="{{ asset('img/team-1.png') }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
            </div>
          </div>
          
          <div class="col-auto my-auto">
            <div class="h-100">
              <p class="form-control-plaintext">{{ $dosen->nm_sdm }}</p>
              <p class="mb-0 font-weight-bold text-sm">
                <p class="form-control-plaintext">{{ $dosen->nidn }}</p>
              </p>
            </div>
          </div>
        
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                
              </div>
            </div>
            <div class="card-body">
              <p class="text-uppercase text-sm">Dosen Information</p>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">NIDN</label>
                    <p class="form-control-plaintext">{{ $dosen->nidn }}</p>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Nama Lengkap</label>
                    <p class="form-control-plaintext">{{ $dosen->nm_sdm }}</p>
                  </div>
                </div>
                
                
              </div>

              <div class="col-md-12">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Perguruan Tinggi</label>
                    <p class="form-control-plaintext">{{ $dosen->nama_pt }}</p>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Prodi</label>
                    <p class="form-control-plaintext">{{ $dosen->prodi }}</p>
                  </div>
                </div>
              <hr class="horizontal dark">
              
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-profile">
            <img src="{{ asset('img/bg.jpg') }}" alt="Image placeholder" class="card-img-top">
            <div class="row justify-content-center">
              <div class="col-4 col-lg-4 order-lg-2">
                <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                  <a href="javascript:;">
                    <img src="{{ asset('img/team-1.png') }}" class="rounded-circle img-fluid ">
                  </a>
                </div>
              </div>
            </div>

              <div class="text-center mt-4">
                <p class="form-control-plaintext">{{ $dosen->nm_sdm }}</p>
                <div class="h6 font-weight-300">
                  <p class="form-control-plaintext">{{ $dosen->nidn }}</p>
                </div>
                <div class="h6 mt-4">
                  <i class="ni business_briefcase-24 mr-2"></i>
                </div>
                <div>
                  <i class="ni education_hat mr-2"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="container-fluid py-4">
        @yield('content')
    </div>
      @endsection
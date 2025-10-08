<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset ('img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset ('img/favicon.png') }}">
    <title>Prodi Teknologi Rekayasa Sistem Elektronika</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset ('css/nucleo-icons.css') }}"  rel="stylesheet" />
    <link href="{{ asset ('css/nucleo-svg.css') }}" rel="stylesheet" />
    <link href="{{ asset ('css/icon.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-a..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMbW/k7CfK7i72z4C6E9Db6GzFv57f73i7yFDu/" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link id="pagestyle" href="{{ asset ('css/argon-dashboard.css?v=2.0.4') }}" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset ('css/table.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=gpp_bad" />
    <!-- jQuery (sudah disertakan sebelumnya, tapi pastikan hanya sekali) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <!-- FixedColumns CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css" />
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>

    <!-- Sertakan Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <link id="pagestyle" href="{{ asset ('css/table.css') }}" rel="stylesheet" />
    <style>
        #sidenav-main .nav-link:hover {
        background-color: rgba(0,0,0,0.05);
        }
        #sidenav-main .nav-link.active {
        background-color: rgba(13,110,253,0.1);
        color: #0d6efd;
        }
        #datatable-ti td {
            border-right: 1px solid #ccc; /* Warna abu-abu */
        }
        #datatable-ti th,
        #datatable-ti thead th {
        text-align: center !important;
        }
        #datatable-ti th:last-child,
        #datatable-ti td:last-child {
            border-right: none;
        }
        #datatable-ti {
        border-collapse: collapse;
        }
        #datatable-ti_wrapper .dataTables_paginate .paginate_button {
            font-size: 12px;
            padding: 2px 6px;
        }
        #datatable-ti_wrapper .dataTables_paginate .paginate_button.current {
            font-weight: 600;
        }
        #datatable-ti_wrapper .dataTables_info {
            font-size: 12px;  /* Contoh pakai px */
        }
        #sidenav .nav-link:hover {
            background-color: rgba(0,0,0,0.05);
        }
        /* Styling untuk menu active */
        #sidenav .nav-link.active {
            background-color: rgba(13,110,253,0.1);
            color: #0d6efd;
        }
    </style>
    
</head>

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 position-absolute w-100" style="background-color: #344767;"></div>

    <!-- Sidenav -->
    <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
        <div class="sidenav-header">
          <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
             aria-hidden="true" id="iconSidenav"></i>
          <a class="navbar-brand m-0" href="#">
            <img src="{{ asset('img/logo-ct-dark.png') }}" class="navbar-brand-img h-100" alt="main_logo" style="width:30%;">
            <span class="ms-1 font-weight-bold">Admin TRSE</span>
          </a>
        </div>
        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('admintrse.index4') ? 'active' : '' }}"
                     href="{{ route('admintrse.index4') }}">
                    {{-- Font Awesome icon --}}
                    <i class="fas fa-database me-2"></i>
                    <span class="nav-link-text">Input Data</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('admintrse.save_datatrse') ? 'active' : '' }}"
                     href="{{ route('admintrse.save_datatrse') }}">
                    <i class="fas fa-save me-2"></i>
                    <span class="nav-link-text">Data Tersimpan</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('admintrse.edit') ? 'active' : '' }}"
                     href="{{ route('admintrse.edit', auth()->user()->id) }}">
                    <i class="fas fa-edit me-2"></i>
                    <span class="nav-link-text">Edit Data</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('admintrse.insert') ? 'active' : '' }}"
                     href="{{ route('admintrse.insert') }}">
                    <i class="fas fa-plus-circle me-2"></i>
                    <span class="nav-link-text">Tambah Data</span>
                  </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('jadwal.admintrse') }}" class="nav-link {{ request()->routeIs('jadwal.admintrse') ? 'active' : '' }}">
                        <i class="fa fa-calendar-alt me-2"></i> Jadwal
                    </a>
                </li>
          </ul>
        </div>
        <br><br><br>
        <div class="sidenav-footer mx-3">
          <div class="card card-plain shadow-none" id="sidenavCard">
            <img class="w-50 mx-auto" src="{{ asset('img/illustrations/icon-documentation.svg') }}" alt="sidebar_illustration">
          </div>
          <div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-dark btn-sm w-100 mb-4">Log Out</button>
            </form>
          </div>
        </div>
      </aside>

    <!-- Main content -->
    <main class="main-content position-relative border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">@yield('page-title')</li>
                    </ol>
                    <h6 class="font-weight-bolder text-white mb-0">@yield('page-title')</h6>
                </nav>
            </div>
        </nav>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            @yield('content')
        </div>
 
        {{-- SweetAlert --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready(function () {
                $('#datatable-ti').DataTable({
                    scrollX: true,
                    scrollCollapse: true,
                    fixedColumns: {
                        leftColumns: 1 
                    },
                    "lengthMenu": [5, 10, 15, 25, 50, 100],
                    "scrollX": true,
                    "language": {
                        "lengthMenu": "Tampilkan _MENU_ baris per halaman",
                        "zeroRecords": "Tidak ditemukan data yang cocok",
                        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        "infoEmpty": "Tidak ada data",
                        "infoFiltered": "(disaring dari total _MAX_ data)",
                        "search": "Cari:",
                        "paginate": {
                            "next": "Berikutnya",
                            "previous": "Sebelumnya"
                        }
                    }
                });

                // Select/Deselect All
                $('#checkAll').on('change', function () {
                    $('input[name="pilihan[]"]').prop('checked', this.checked);
                });
            });

            // SweetAlert on Save Button
            document.getElementById('btn-confirm').addEventListener('click', function () {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dipilih akan disimpan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('form-pilih').submit();
                    }
                });
            });

            // Alert handling for session messages
                @if(session('success') && session('success_redirect'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: {!! json_encode(session('success_redirect')) !!},
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('admintrse.save_datatrse') }}";
                    }
                });
                @endif

                @if(session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: {!! json_encode(session('error')) !!},
                        confirmButtonText: 'OK'
                    });
                @endif

                @if($errors->any())
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal',
                        text: {!! json_encode($errors->first()) !!},
                        confirmButtonText: 'OK'
                    });
                @endif
</script>

    </main>
</body>

</html>

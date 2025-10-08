<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Login</title>
    <style>
        .input-field {
            position: relative;
        }
        .show-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container main">
            <div class="row">
                <div class="col-md-6 side-image">
                    <!-- Gambar atau konten lain di sini -->
                </div>
                <div class="col-md-6 right">
                    <form method="POST" action="{{ route('login') }}"> 
                        @csrf
                        <div class="input-box">
                            <header style="text-align: center; font-size: 24px; text-transform: uppercase;">LOGIN</header>
                            <div class="input-field">
                                <input type="text" class="input" name="username" required autocomplete="off">
                                <label for="username">Username</label> 
                            </div>
                            <div class="input-field">
                                <input type="password" class="input" id="password" name="password" required>
                                <label for="password">Password</label>
                                <span class="show-password" onclick="togglePassword()">
                                    <i class="fas fa-eye" id="toggle-icon"></i> <!-- Ikon mata dari Font Awesome -->
                                </span>
                            </div>
                            <div class="input-field">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </div>  
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggle-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash'); // Ganti ikon menjadi mata tertutup
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye'); // Kembali ke ikon mata terbuka
            }
        }

        // Menampilkan SweetAlert jika ada error message
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK'
                });
            @endif

            
            @if($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ $errors->first() }}',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('public/hwi.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('resources/css/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/fontawesome/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .center-text {
            text-align: center;
        }

        .center-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        th,
        td {
            vertical-align: middle !important;
        }

        .custom-container {
            max-width: 1750px;
            margin: 0 auto;
        }

        .alert {
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            opacity: 1;
            transition: opacity 0.6s;
            margin-bottom: 15px;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .space-before-colon {
            padding-left: 5px;
            /* Atur jarak sesuai kebutuhan */
        }

        .custom-img {
            width: 200px;
            /* Atur lebar gambar sesuai kebutuhan */
            height: auto;
            /* Atur tinggi gambar sesuai kebutuhan */
            object-fit: cover;
            /* Memotong gambar agar sesuai dengan ukuran */
            /* Membuat gambar menjadi lingkaran, jika diinginkan */
        }

        /* CSS untuk tombol dalam Flexbox */
        .btn-group {
            margin-right: 10px;
            /* Jarak antar tombol */
        }

        .btn:last-child {
            margin-right: 0;
            /* Menghapus margin di tombol terakhir */
        }

        .form-row {
            display: flex;
            gap: 1rem;
            /* Atur jarak antar kolom sesuai kebutuhan */
        }

        .form-row .col {
            flex: 1;
        }

        .bold-text {
            font-weight: bold;
            font-size: 20px
        }

        /* Margin tambahan untuk tabel di mode mobile */
        @media (max-width: 767px) {
            .table-responsive {
                margin-bottom: 20px;
                /* Sesuaikan dengan nilai yang diinginkan */
            }
        }
    </style>
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container custom-container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    QIP TEAM
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
        
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
        
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Tautan Data Training ditampilkan untuk semua pengguna -->
                        <li class="nav-item text-center">
                            <a class="btn" href="{{ route('trainings.index') }}">{{ __('Data Training') }}</a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="btn" href="{{ route('gedung.index') }}">{{ __('Data Gedung') }}</a>
                        </li>
                        
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="btn btn-primary btn-custom" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item" style="display: none;">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item text-center">
                                <a class="btn" href="{{ route('employees.create') }}">{{ __('Tambah Karyawan') }}</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                                </a>
        
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
        
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        
        @if (session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif
    </header>

    <main>
        <div class="container custom-container">
            @yield('content')
        </div>
    </main>

    <footer>
        <!-- Footer konten bisa ditambahkan di sini -->
    </footer>

    <!-- JavaScript atau library lainnya -->
    <script src="{{ asset('resources/js/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('resources/js/popper/popper.min.js') }}"></script>
    <script src="{{ asset('resources/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('resources/js/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('resources/js/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('resources/js/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('resources/js/show.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#employees-table').DataTable();
        });
        $(document).ready(function() {
            $('#trainingsTable').DataTable();
        });

        setTimeout(function() {
            var alert = document.querySelector('.alert');
            if (alert) {
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 600);
            }
        }, 3000);
    </script>
    @yield('scripts')
</body>

</html>

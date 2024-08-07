<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="icon" href="{{asset('public/hwi.ico')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('resources/css/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/fontawesome/all.min.css') }}">
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
        th, td {
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
    </style>
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container custom-container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    QIP TEAM
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
     
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <!-- Tautan lainnya -->
                    </ul>
     
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
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
                            <li class="nav-item">
                                <a class="btn btn-primary btn-customm" href="{{ route('employees.create') }}">{{ __('Tambah Karyawan') }}</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
     
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
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
    <script src="{{ asset('resources/js/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('resources/js/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('resources/js/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('resources/js/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('resources/js/show.js') }}"></script>


    <script>
        $(document).ready(function() {
            $('#employees-table').DataTable();
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
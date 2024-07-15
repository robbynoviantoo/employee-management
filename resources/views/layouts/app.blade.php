<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
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
        }
    </style>
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container custom-container">
                <a class="navbar-brand" href="/">QIP TEAM</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item {{ request()->routeIs('employees.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('employees.index') }}">Daftar Karyawan</a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('employees.create') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('employees.create') }}">Tambah Karyawan</a>
                        </li>
                        <!-- Tambahkan menu navigasi lainnya sesuai kebutuhan -->
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
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
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
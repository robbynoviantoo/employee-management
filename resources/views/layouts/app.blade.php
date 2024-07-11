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
</head>

<body>
    <!-- CSS, JS, atau library lainnya -->
    </head>

    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container">
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
        </header>

        <main>
            <div class="container">
                @yield('content')
            </div>

        </main>

        <footer>
            <!-- Footer konten bisa ditambahkan di sini -->
        </footer>

        <!-- JavaScript atau library lainnya -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#employees-table').DataTable();
            });
        </script>
    </body>

</html>

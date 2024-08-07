@extends('layouts.app')

@section('title', 'Training Detail')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Detail Training untuk NIK: {{ $employee->nik }}</h1>

        <!-- Informasi Karyawan -->
        <div style="padding: 25px; background-color:#fff; border-radius:20px; box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
            <div class="row mb-4">
                <div class="col-md-3">
                    @if ($employee->photo)
                        <img src="{{ asset('storage/app/public/' . $employee->photo) }}" alt="Foto {{ $employee->nik }}"
                            class="img-fluid img-thumbnail custom-img">
                    @else
                        <img src="{{ asset('images/default-avatar.png') }}" alt="Foto {{ $employee->nik }}"
                            class="img-fluid img-thumbnail custom-img">
                    @endif
                </div>
                <div class="col-md-9">
                    <h4>{{ $employee->name }}</h4>
                    <table class="table table-sm">
                        <tr>
                            <td>Position</td>
                            <td class="space-before-colon">: {{ $employee->position }}</td>
                        </tr>
                        <tr>
                            <td>Gedung</td>
                            <td class="space-before-colon">: {{ $employee->building }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Masuk</td>
                            <td class="space-before-colon">: {{ $employee->datein }}</td>
                        </tr>
                        <tr>
                            <td>ID Pass</td>
                            <td class="space-before-colon">: {{ $employee->idpass }}</td>
                        </tr>
                        <tr>
                            <td>No. Handphone</td>
                            <td class="space-before-colon">: {{ '0' . $employee->phone }}</td>
                        </tr>
                    </table>

                    <!-- Dropdown untuk memilih kategori -->
                    <div class="dropdown mt-3">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Pilihan Kategori
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @foreach ($categories as $category)
                                <li><a class="dropdown-item" href="#"
                                        onclick="showTable('{{ $category }}')">{{ $category }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Tampilkan tabel berdasarkan kategori -->
            <h2>Hasil Tes</h2>
            <div class="table-responsive">
                @foreach ($categories as $category)
                    <table id="{{ strtolower($category) }}" class="table table-sm table-bordered d-none">
                        <thead class="thead-light">
                            <tr>
                                <th>Materi</th>
                                <th>Tanggal Tes</th>
                                <th>1st Score</th>
                                <th>Retest Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materis->where('kategori', $category) as $materi)
                                @php
                                    // Ambil data training untuk materi saat ini
                                    $training = $trainingData->where('materi_id', $materi->id)->first();
                                @endphp
                                <tr>
                                    <td>{{ $materi->materi_name }}</td>
                                    <td>{{ $training->tanggal ?? 'N/A' }}</td>
                                    <td>{{ $training->first_score ?? 'N/A' }}</td>
                                    <td>{{ $training->retest_score ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
        </div>

        <!-- Link kembali -->
        <a href="{{ route('employees.index') }}" class="btn btn-primary mt-3">Kembali ke Daftar Karyawan</a>
    </div>

    <!-- JavaScript untuk menampilkan tabel sesuai pilihan dropdown -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set default table to show
            showTable('{{ $categories->first() }}');
        });

        function showTable(category) {
            // Sembunyikan semua tabel
            const tables = document.querySelectorAll('.table-responsive .table');
            tables.forEach(table => {
                table.classList.add('d-none');
            });

            // Tampilkan tabel yang sesuai dengan kategori yang dipilih
            const selectedTable = document.getElementById(category.toLowerCase());
            if (selectedTable) {
                selectedTable.classList.remove('d-none');
            }

            // Update dropdown button text
            const dropdownButton = document.getElementById('dropdownMenuButton');
            dropdownButton.textContent = category;
        }
    </script>
@endsection

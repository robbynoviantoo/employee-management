@extends('layouts.app')

@section('title', 'Training Detail')

@section('content')
<style>
    .table, .table th, .table td {
        border: 1px solid #dee2e6; /* Warna border dapat disesuaikan */
    }
    .table th, .table td {
        padding: 0.3rem; /* Jarak padding di dalam sel */
    }
</style>

    <div class="container mt-4">

        <!-- Informasi Karyawan -->
        <div
            style="padding: 25px; background-color:#fff; border-radius:20px; box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px; margin-bottom:40px; margin-top:40px">
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
                <div class="col-md-5">
                    <h2 style="font-weight: bold">{{ $employee->name }}</h2>
                    <table class="table">
                        <tr>
                            <td>NIK</td>
                            <td class="space-before-colon">: {{ $employee->nik }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir</td>
                            <td class="space-before-colon">: {{ \Carbon\Carbon::parse($employee->tanggallahir)->format('d-m-Y') }}</td>
                        </tr>
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
                </div>
                <div class="col-md-3">
                    <h2 style="font-weight: bold">Absensi 1 Tahun</h2>
                    <table class="table">
                        <tr>
                            <td>Sakit</td>
                            <td>{{ $sickCount }}</td>
                        </tr>
                        <tr>
                            <td>Alpha</td>
                            <td>{{ $alphaCount }}</td>
                        </tr>
                        <tr>
                            <td>Cuti</td>
                            <td>{{ $leaveCount }}</td>
                        </tr>
                        <tr>
                            <td>Ijin</td>
                            <td>{{ $ijinCount }}</td>
                        </tr>
                    </table>

                    <!-- Dropdown untuk memilih kategori -->
                </div>
                <div class="dropdown mt-3">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
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
            <!-- Link kembali -->
            <a href="{{ route('employees.index') }}" class="btn btn-primary mt-3">Kembali ke Daftar Karyawan</a>
        </div>
        </div>


    <!-- JavaScript untuk menampilkan tabel sesuai pilihan dropdown -->
    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Set default table to show
    const firstCategory = '{{ $categories->first() }}';
    if (firstCategory) {
        showTable(firstCategory);
    }
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

        // Tambahkan sedikit penundaan sebelum scroll
        setTimeout(() => {
            selectedTable.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }, 100); // 100ms penundaan

        // Jika ada header tetap, tambahkan offset
        const headerOffset = document.querySelector('header')?.offsetHeight || 0; // Ganti dengan selector header jika diperlukan
        window.scrollBy(0, -headerOffset);
    }

    // Update dropdown button text
    const dropdownButton = document.getElementById('dropdownMenuButton');
    dropdownButton.textContent = category;
}

    </script>
@endsection

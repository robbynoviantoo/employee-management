@extends('layouts.app')

@section('title', 'Tambah Data Training')

@section('content')
    <div class="container">
        <h1 class="mb-4">Tambah Data Training</h1>
        <form action="{{ route('trainings.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nik">NIK</label>
                <select id="nik" name="nik" class="form-control @error('nik') is-invalid @enderror" required>
                    <option value="">Pilih NIK</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->nik }}" data-nama="{{ $employee->name }}" {{ old('nik') == $employee->nik ? 'selected' : '' }}>
                            {{ $employee->nik }}
                        </option>
                    @endforeach
                </select>
                @error('nik')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Menampilkan Nama Karyawan -->
            <div class="form-group mt-2">
                <label for="employee_name">Nama Karyawan</label>
                <input type="text" id="employee_name" class="form-control" readonly>
            </div>

            <div class="form-group mt-4">
                <label for="kategori">Kategori Materi</label>
                <select id="kategori" name="kategori" class="form-control @error('kategori') is-invalid @enderror" onchange="filterMateri()">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoriList as $kategori)
                        <option value="{{ $kategori }}" {{ old('kategori', $defaultKategori) == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                    @endforeach
                </select>
                @error('kategori')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <h3 class="mt-4">Materi Training</h3>
            <div id="materi-sections">
                @foreach ($materis as $materi)
                    <div class="form-group materi-item" data-kategori="{{ $materi->kategori }}">
                        <label class="bold-text">{{ $materi->materi_name }}</label>
                        <input type="hidden" name="materis[]" value="{{ $materi->id }}">
                        <div class="form-row mb-2">
                            <div class="col">
                                <label for="tanggal_{{ $materi->id }}">Tanggal</label>
                                <input type="date" id="tanggal_{{ $materi->id }}" name="tanggal[{{ $materi->id }}]" class="form-control @error('tanggal.' . $materi->id) is-invalid @enderror" value="{{ old('tanggal.' . $materi->id) }}">
                                @error('tanggal.' . $materi->id)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="first_score_{{ $materi->id }}">1st Score</label>
                                <input type="number" step="0.01" id="first_score_{{ $materi->id }}" name="first_score[{{ $materi->id }}]" class="form-control @error('first_score.' . $materi->id) is-invalid @enderror" value="{{ old('first_score.' . $materi->id) }}">
                                @error('first_score.' . $materi->id)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="retest_score_{{ $materi->id }}">Retest Score</label>
                                <input type="number" step="0.01" id="retest_score_{{ $materi->id }}" name="retest_score[{{ $materi->id }}]" class="form-control @error('retest_score.' . $materi->id) is-invalid @enderror" value="{{ old('retest_score.' . $materi->id) }}">
                                @error('retest_score.' . $materi->id)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        </form>
    </div>
    

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            filterMateri(); // Panggil fungsi filterMateri saat halaman dimuat

            // Tampilkan nama karyawan saat NIK dipilih
            document.getElementById('nik').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const employeeName = selectedOption.getAttribute('data-nama');
                document.getElementById('employee_name').value = employeeName || '';
            });
        });

        function filterMateri() {
            const selectedKategori = document.getElementById('kategori').value;
            const materiItems = document.querySelectorAll('.materi-item');

            materiItems.forEach(item => {
                if (selectedKategori === "" || item.getAttribute('data-kategori') === selectedKategori) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    </script>
@endsection

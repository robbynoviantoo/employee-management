@extends('layouts.app')

@section('title', 'Tambah Data Training')

@section('content')
    <style>
        .select2-container--default .select2-selection--single {
            height: 40px;
            line-height: 40px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
            top: 0;
        }

        .select2-container--default .select2-dropdown {
            max-height: 300px;
        }

        .select2-container--default .select2-results__option {
            line-height: 30px;
        }
    </style>
    <div class="container"
        style="padding: 30px; background-color:#fff; margin-top: 30px; margin-bottom: 30px; border-radius: 30px; box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
        <h1 class="mb-4">Tambah Data Training</h1>
        <form action="{{ route('trainings.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nik">NIK</label>
                <select id="nik" name="nik" class="form-control @error('nik') is-invalid @enderror" required>
                    <option value="">Pilih NIK</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->nik }}" data-nama="{{ $employee->name }}"
                            {{ old('nik') == $employee->nik ? 'selected' : '' }}>
                            {{ $employee->nik }} - {{ $employee->name }}
                        </option>
                    @endforeach
                </select>
                @error('nik')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mt-4">
                <label for="kategori">Kategori Materi</label>
                <select id="kategori" name="kategori" class="form-select @error('kategori') is-invalid @enderror"
                    onchange="filterMateri()">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoriList as $kategori)
                        <option value="{{ $kategori }}"
                            {{ old('kategori', $defaultKategori) == $kategori ? 'selected' : '' }}>{{ $kategori }}
                        </option>
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
                                <input type="date" id="tanggal_{{ $materi->id }}" name="tanggal[{{ $materi->id }}]"
                                    class="form-control @error('tanggal.' . $materi->id) is-invalid @enderror"
                                    value="{{ old('tanggal.' . $materi->id) }}">
                                @error('tanggal.' . $materi->id)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="first_score_{{ $materi->id }}">1st Score</label>
                                <input type="number" step="0.01" id="first_score_{{ $materi->id }}"
                                    name="first_score[{{ $materi->id }}]"
                                    class="form-control @error('first_score.' . $materi->id) is-invalid @enderror"
                                    value="{{ old('first_score.' . $materi->id) }}">
                                @error('first_score.' . $materi->id)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="retest_score_{{ $materi->id }}">Retest Score</label>
                                <input type="number" step="0.01" id="retest_score_{{ $materi->id }}"
                                    name="retest_score[{{ $materi->id }}]"
                                    class="form-control @error('retest_score.' . $materi->id) is-invalid @enderror"
                                    value="{{ old('retest_score.' . $materi->id) }}">
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
            // Inisialisasi Select2 pada dropdown NIK
            $('#nik').select2({
                placeholder: 'Pilih NIK',
                allowClear: true
            });

            // Panggil fungsi filterMateri saat halaman dimuat pertama kali
            filterMateri();
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

        // Event listener untuk dropdown kategori
        document.getElementById('kategori').addEventListener('change', filterMateri);
    </script>
@endsection

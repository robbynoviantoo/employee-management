@extends('layouts.app')

@section('title', 'Edit Absensi')

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
    <div class="container">
        <h1>Edit Absensi</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('absences.update', $absence->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ $absence->tanggal }}" required>
                @error('tanggal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="nik">NIK</label>
                <select id="nik" name="nik" class="form-control @error('nik') is-invalid @enderror" required>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->nik }}" {{ $absence->nik == $employee->nik ? 'selected' : '' }}>
                            {{ $employee->nik }} - {{ $employee->name }}
                        </option>
                    @endforeach
                </select>
                @error('nik')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="alasan" class="form-label">Alasan</label>
                <select class="form-select" id="alasan" name="alasan" required>
                    <option value="Sakit" {{ $absence->alasan == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="Alpha" {{ $absence->alasan == 'Alpha' ? 'selected' : '' }}>Alpha</option>
                    <option value="Cuti" {{ $absence->alasan == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                    <option value="Ijin" {{ $absence->alasan == 'Ijin' ? 'selected' : '' }}>Ijin</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <input type="text" class="form-control" id="keterangan" name="keterangan"
                    value="{{ $absence->keterangan }}">
            </div>
            <button type="submit" class="btn btn-primary">Update Absensi</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi Select2 pada dropdown NIK
            $('#nik').select2({
                placeholder: 'Pilih NIK',
                allowClear: true,
                width: '100%' // Memastikan lebar Select2 adalah 100% dari elemen induknya
            });
        });
    </script>
@endsection

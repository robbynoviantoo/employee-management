@extends('layouts.app')

@section('title', 'Absensi')

@section('content')
<div class="container mt-3">
    <h1>Absensi Hari Ini</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ route('absences.store') }}" method="POST">
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
        <div class="mb-3">
            <label for="alasan" class="form-label">Alasan</label>
            <select class="form-control" id="alasan" name="alasan" required>
                <option value="" disabled selected>Pilih Alasan</option>
                <option value="Sakit">Sakit</option>
                <option value="Alpha">Alpha</option>
                <option value="Cuti">Cuti</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" class="form-control" id="keterangan" name="keterangan">
        </div>
        <button type="submit" class="btn btn-primary">Simpan Absensi</button>
    </form>

    <hr>
    <h2 class="mt-3">Daftar Karyawan Tidak Hadir</h2>
    <table id="absences-table" class="table table-striped">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Alasan</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absences as $absence)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($absence->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $absence->nik }}</td>
                    <td>{{ $absence->employee->name }}</td> <!-- Menggunakan relasi employee untuk mengambil nama -->
                    <td>{{ $absence->alasan }}</td>
                    <td>{{ $absence->keterangan }}</td>
                    <td>
                        <a href="{{ route('absences.edit', $absence->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('absences.destroy', $absence->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus absensi ini?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi Select2 pada dropdown NIK
    $('#nik').select2({
        placeholder: 'Pilih NIK',
        allowClear: true
    });
});
</script>
@endsection

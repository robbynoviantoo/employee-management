@extends('layouts.app')

@section('title', 'Edit Absensi')

@section('content')
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
            <select class="form-control" id="alasan" name="alasan" required>
                <option value="Sakit" {{ $absence->alasan == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                <option value="Alpha" {{ $absence->alasan == 'Alpha' ? 'selected' : '' }}>Alpha</option>
                <option value="Cuti" {{ $absence->alasan == 'Cuti' ? 'selected' : '' }}>Cuti</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ $absence->keterangan }}">
        </div>
        <button type="submit" class="btn btn-primary">Update Absensi</button>
    </form>
</div>
@endsection

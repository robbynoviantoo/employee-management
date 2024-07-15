@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Edit Karyawan</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nik">NIK:</label>
                        <input type="text" class="form-control" name="nik" id="nik"
                            value="{{ $employee->nik }}" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Nama:</label>
                        <input type="text" class="form-control" name="name" id="name"
                            value="{{ $employee->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Gambar:</label>
                        <input type="file" class="form-control" name="image" id="image">
                        @if ($employee->image)
                            <img src="{{ asset('storage/' . $employee->image) }}" alt="Employee Image"
                                class="img-thumbnail mt-2" width="150">
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="jabatan">Jabatan:</label>
                        <input type="text" class="form-control" name="position" id="position"
                            value="{{ $employee->position }}" required>
                    </div>
                    <div class="form-group">
                        <label for="building">Gedung:</label>
                        <input type="text" class="form-control" name="building" id="building"
                            value="{{ $employee->building }}" required>
                    </div>
                    <div class="form-group">
                        <label for="area">Area:</label>
                        <input type="text" class="form-control" name="area" id="area"
                            value="{{ $employee->area }}" required>
                    </div>
                    <div class="form-group">
                        <label for="cell">Cell:</label>
                        <input type="text" class="form-control" name="cell" id="cell"
                            value="{{ $employee->cell }}" required>
                    </div>
                    <div class="form-group">
                        <label for="idpass">ID Pass:</label>
                        <input type="text" class="form-control" name="idpass" id="idpass"
                            value="{{ $employee->idpass }}">
                    </div>
                    <div class="form-group">
                        <label for="phone">No. Handphone:</label>
                        <input type="tel" class="form-control" name="phone" id="phone"
                            value="{{ $employee->phone }}" required>
                    </div>
                    <div class="form-group">
                        <label for="datein">Tanggal Masuk:</label>
                        <input type="text" class="form-control" name="datein" id="datein"
                            value="{{ $employee->datein }}" required>
                    </div>
                    <div class="form-group">
                        <label for="dateout">Tanggal Resign:</label>
                        <input type="text" class="form-control" name="dateout" id="dateout"
                            value="{{ $employee->dateout }}">
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select class="form-control" name="status" id="status" required>
                            <option value="On Work" {{ $employee->status == 'On Work' ? 'selected' : '' }}>On Work</option>
                            <option value="Resigned" {{ $employee->status == 'Resigned' ? 'selected' : '' }}>Resigned
                            </option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection

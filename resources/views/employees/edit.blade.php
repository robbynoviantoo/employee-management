@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
        <div class="card shadow-sm costum-rounded">
            <div class="card-header text-dark">
                <h4 class="mb-0">Edit Karyawan</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('employees.update', $employee->nik) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nik">NIK:</label>
                        <input type="text" class="form-control" name="nik" id="nik"
                            value="{{ old('nik', $employee->nik) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Nama:</label>
                        <input type="text" class="form-control" name="name" id="name"
                            value="{{ old('name', $employee->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggallahir">Tanggal Lahir:</label>
                        <input type="date" class="form-control" name="tanggallahir" id="tanggallahir"
                            value="{{ old('tanggallahir', $employee->tanggallahir) }}" nullable>
                    </div>
                    <div class="form-group">
                        <label for="gender">Jenis Kelamin:</label>
                        <input type="text" class="form-control" name="gender" id="gender"
                            value="{{ old('gender', $employee->gender) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Gambar:</label>
                        <input type="file" class="form-control" name="image" id="image">
                        @if ($employee->photo)
                            <img src="{{ asset('storage/app/public/' . $employee->photo) }}" alt="Employee Image"
                                class="img-thumbnail mt-2" width="150">
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="position">Jabatan:</label>
                        <input type="text" class="form-control" name="position" id="position"
                            value="{{ old('position', $employee->position) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="building">Gedung:</label>
                        <select class="form-control" name="building" id="building" required>
                            <option value="">Pilih Gedung</option>
                            @foreach ($buildings as $building)
                                <option value="{{ $building->gedung }}" 
                                    {{ old('building', $employee->building) == $building->gedung ? 'selected' : '' }}>
                                    {{ $building->gedung }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="area">Area:</label>
                        <input type="text" class="form-control" name="area" id="area"
                            value="{{ old('area', $employee->area) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="cell">Cell:</label>
                        <input type="text" class="form-control" name="cell" id="cell"
                            value="{{ old('cell', $employee->cell) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="idpass">ID Pass:</label>
                        <input type="text" class="form-control" name="idpass" id="idpass"
                            value="{{ old('idpass', $employee->idpass) }}">
                    </div>
                    <div class="form-group">
                        <label for="phone">No. Handphone:</label>
                        <input type="tel" class="form-control" name="phone" id="phone"
                            value="{{ old('phone', $employee->phone) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="datein">Tanggal Masuk:</label>
                        <input type="date" class="form-control" name="datein" id="datein"
                            value="{{ old('datein', $employee->datein) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="dateout">Tanggal Resign:</label>
                        <input type="date" class="form-control" name="dateout" id="dateout"
                            value="{{ old('dateout', $employee->dateout) }}">
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select class="form-control" name="status" id="status" required>
                            <option value="On Work" {{ old('status', $employee->status) == 'On Work' ? 'selected' : '' }}>On Work</option>
                            <option value="Resigned" {{ old('status', $employee->status) == 'Resigned' ? 'selected' : '' }}>Resigned</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buildingSelect = document.getElementById('building');
            const areaSelect = document.getElementById('area');

            // Update areas based on the selected building
            buildingSelect.addEventListener('change', function() {
                const building = this.value;
                fetch(`http://10.20.100.70/employee-management/areas/${building}`)
                    .then(response => response.json())
                    .then(data => {
                        areaSelect.innerHTML = '<option value="">Pilih Area</option>';
                        data.forEach(area => {
                            const option = document.createElement('option');
                            option.value = area;
                            option.textContent = area;
                            areaSelect.appendChild(option);
                        });
                    });
            });

            // Trigger change event to populate areas on page load if needed
            if (buildingSelect.value) {
                buildingSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endsection

@section('styles')
    <style>
        .card-header {
            background-color: var(--bs-primary); /* Menggunakan warna dari navbar */
        }
    </style>
@endsection

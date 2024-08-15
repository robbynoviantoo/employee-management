@extends('layouts.app')

@section('title', 'Tambah Karyawan')

@section('content')
    </nav>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header navbar-dark bg-dark text-white">
                        <h3 class="mb-0">Tambah Karyawan</h3>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" class="form-control" name="nik" id="nik"
                                    value="{{ old('nik') }}" placeholder="Masukkan NIK" required>
                            </div>
                            <div class="form-group">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ old('name') }}" placeholder="Masukkan jenis kelamin" required>
                            </div>
                            <div class="form-group">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <input type="text" class="form-control" name="gender" id="gender"
                                    value="{{ old('gender') }}" placeholder="Masukkan nama" required>
                            </div>
                            <div class="form-group">
                                <label for="photo" class="form-label">Foto</label>
                                <input class="form-control-file" type="file" name="photo" id="photo">
                            </div>
                            <div class="form-group">
                                <label for="position" class="form-label">Jabatan</label>
                                <input type="text" class="form-control" name="position" id="position"
                                    value="{{ old('position') }}" placeholder="Masukkan jabatan" required>
                            </div>
                            <div class="form-group">
                                <label for="building" class="form-label">Gedung</label>
                                <input type="text" class="form-control" name="building" id="building"
                                    value="{{ old('building') }}" placeholder="Masukkan gedung" required>
                            </div>
                            <div class="form-group">
                                <label for="area" class="form-label">Area</label>
                                <input type="text" class="form-control" name="area" id="area"
                                    value="{{ old('area') }}" placeholder="Masukkan area" required>
                            </div>
                            <div class="form-group">
                                <label for="cell" class="form-label">Cell</label>
                                <input type="text" class="form-control" name="cell" id="cell"
                                    value="{{ old('cell') }}" placeholder="Masukkan cell" required>
                            </div>
                            <div class="form-group">
                                <label for="idpass" class="form-label">ID Pass</label>
                                <input type="text" class="form-control" name="idpass" id="idpass"
                                    value="{{ old('idpass') }}" placeholder="Masukkan ID Pass">
                            </div>
                            <div class="form-group">
                                <label for="phone" class="form-label">No. Handphone</label>
                                <input type="tel" class="form-control" name="phone" id="phone"
                                    value="{{ old('phone') }}" placeholder="Masukkan no. handphone" required>
                                <small id="phoneHelpBlock" class="form-text text-muted" style="display: none;"></small>
                            </div>
                            <div class="form-group">
                                <label for="datein" class="form-label">Tanggal Masuk</label>
                                <input type="date" class="form-control" name="datein" id="datein"
                                    value="{{ old('datein', date('Y-m-d')) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="dateout" class="form-label">Tanggal Resign</label>
                                <input type="date" class="form-control" name="dateout" id="dateout"
                                    value="{{ old('dateout') }}">
                            </div>
                            <div class="form-group">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" name="status" id="status" required>
                                    <option value="On Work">On Work</option>
                                    <option value="Resigned">Resigned</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('phone').addEventListener('input', function(e) {
            const phoneInput = e.target;
            const phoneValue = phoneInput.value;
            const phoneHelpBlock = document.getElementById('phoneHelpBlock');

            if (!/^\d*$/.test(phoneValue)) {
                phoneHelpBlock.textContent = 'Nomor handphone hanya boleh berisi angka!';
                phoneHelpBlock.style.color = 'red';
                phoneHelpBlock.style.display = 'block';
            } else {
                phoneHelpBlock.textContent = '';
                phoneHelpBlock.style.display = 'none';
            }
        });
    </script>
@endsection

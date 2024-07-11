@extends('layouts.app')

@section('title', 'Tambah Karyawan')

@section('content')
  </nav>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>TAMBAH KARYAWAN</h3>
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
                        <form action="{{ route('employees.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" name="name" id="name" required>
                            </div>
                            <div class="form-group">
                                <label for="photo" class="form-label">Foto</label>
                                <input class="form-control-file" type="file" name="photo" id="photo">
                            </div>
                            <div class="form-group">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input type="text" class="form-control" name="position" id="position" required>
                            </div>
                            <div class="form-group">
                                <label for="building" class="form-label">Gedung</label>
                                <input type="text" class="form-control" name="building" id="building" required>
                            </div>
                            <div class="form-group">
                                <label for="area" class="form-label">Area</label>
                                <input type="text" class="form-control" name="area" id="area" required>
                            </div>
                            <div class="form-group">
                                <label for="cell" class="form-label">Cell</label>
                                <input type="text" class="form-control" name="cell" id="cell" required>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="form-label">No. Handphone</label>
                                <input type="tel" class="form-control" name="phone" id="phone" required>
                            </div>
                            <div class="form-group">
                                <label for="datein" class="form-label">Tanggal Masuk</label>
                                <input type="date" class="form-control" name="datein" id="datein" required>
                            </div>
                            <div class="form-group">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" class="form-control" name="status" id="status" required>
                            </div>
                            <button type="submit">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

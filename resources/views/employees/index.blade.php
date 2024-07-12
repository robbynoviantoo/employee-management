@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container mt-5">
    <h1>LIST KARYAWAN</h1>

    <div class="mb-3">
        <a href="{{ route('employees.export') }}" class="btn btn-success">Export to Excel</a>
    </div>
    <div class="container mt-5">
        <h2>Import Karyawan</h2>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('employees.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file">Pilih File Excel</label>
                <input type="file" name="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Import</button>
        </form>
    </div>

    <table id="employees-table" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Foto</th>
                <th>Jabatan</th>
                <th>Gedung</th>
                <th>Area</th>
                <th>Cell</th>
                <th>No.Handphone</th>
                <th>Tanggal Masuk</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->photo }}</td>
                    <td>{{ $employee->position }}</td>
                    <td>{{ $employee->building }}</td>
                    <td>{{ $employee->area }}</td>
                    <td>{{ $employee->cell }}</td>
                    <td>{{ $employee->phone }}</td>
                    <td>{{ $employee->datein }}</td>
                    <td>{{ $employee->status }}</td>
                    <td>
                        <a href="{{ route('employees.edit', ['id' => $employee->id]) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('employees.destroy', ['id' => $employee->id]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin untuk menghapus karyawan ini?')">Hapus</button>
                        </form>
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#employees-table').DataTable();
    });
</script>
@endsection
@extends('layouts.app')

@section('title', 'Data Training')

@section('content')
    <div class="container" style="padding: 30px; background-color:#fff; margin-top: 30px; margin-bottom: 30px; border-radius: 30px; box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
        <h1 class="mb-4">Data Training</h1>
        <a href="{{ route('trainings.create') }}" class="btn btn-primary mb-3">Tambah Data Training</a>
        <a href="{{ route('trainings.export') }}" class="btn btn-success mb-3">Export to Excel</a>
        <a href="{{ route('trainings.form') }}" class="btn btn-warning mb-3">Import to Excel</a>
        <table id="trainingsTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trainings as $training)
                <tr>
                    <td>{{ $training->nik }}</td>
                    <td>
                        <a href="{{ route('trainings.show', $training->nik) }}" class="btn btn-primary">Lihat</a>
                        <a href="{{ route('trainings.edit', $training->nik) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('trainings.destroy', $training->nik) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

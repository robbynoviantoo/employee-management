@extends('layouts.app')

@section('title', 'Data Training')

@section('content')
    <div class="container">
        <h1 class="mb-4">Data Training</h1>
        <a href="{{ route('trainings.create') }}" class="btn btn-primary mb-3">Tambah Data Training</a>
        <table class="table table-bordered">
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
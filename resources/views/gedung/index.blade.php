@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="section-table">
            <h1 class="mb-3">Data Gedung</h1>
            <a href="{{ route('gedung.create') }}" class="btn btn-primary mb-3">Tambah Gedung</a>
            <a href="{{ route('gedung.import') }}" class="btn btn-warning mb-3">Import Gedung</a>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <table id="table-gedung" class="table table-bordered">
                <tr>
                    <th>No</th>
                    <th>Gedung</th>
                    <th>Area</th>
                    <th width="280px">Aksi</th>
                </tr>
                @foreach ($gedung as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->gedung }}</td>
                        <td>{{ $item->area }}</td>
                        <td>
                            <a class="btn btn-info" href="{{ route('gedung.show', $item->id) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('gedung.edit', $item->id) }}">Edit</a>
                            <form action="{{ route('gedung.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection

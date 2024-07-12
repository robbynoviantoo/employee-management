@extends('layouts.app')

@section('title', 'Import Karyawan')

@section('content')
<div class="container mt-5">
    <h2>Import Karyawan</h2>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('import.process') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file">Pilih File Excel</label>
            <input type="file" name="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Import</button>
    </form>
</div>

@endsection
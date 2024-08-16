@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tambah Gedung</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('gedung.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="gedung">Gedung:</label>
                <input type="text" name="gedung" class="form-control" placeholder="Nama Gedung">
            </div>
            <div class="form-group">
                <label for="area">Area:</label>
                <input type="text" name="area" class="form-control" placeholder="Area">
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
@endsection
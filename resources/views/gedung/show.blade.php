@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detail Gedung</h1>
        <div class="form-group">
            <strong>Gedung:</strong>
            {{ $gedung->gedung }}
        </div>
        <div class="form-group">
            <strong>Area:</strong>
            {{ $gedung->area }}
        </div>
        <a class="btn btn-primary" href="{{ route('gedung.index') }}">Kembali</a>
    </div>
@endsection
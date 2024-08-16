@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Gedung</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('gedung.update', $gedung->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="gedung">Gedung:</label>
                <input type="text" name="gedung" value="{{ $gedung->gedung }}" class="form-control">
            </div>
            <div class="form-group">
                <label for="area">Area:</label>
                <input type="text" name="area" value="{{ $gedung->area }}" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
@endsection
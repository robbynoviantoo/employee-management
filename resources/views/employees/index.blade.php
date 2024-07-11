@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

<h1>Daftar Karyawan</h1>
<a href="{{ route('employees.create') }}">Tambah Karyawan</a>
<ul>
    @foreach($employees as $employee)
        <li>{{ $employee->name }} - <a href="{{ route('employees.show', $employee->id) }}">Detail</a></li>
    @endforeach
</ul>
</div>
@endsection
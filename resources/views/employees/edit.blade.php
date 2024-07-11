@extends('layouts.app')

@section('content')
<h1>Edit Karyawan</h1>
<form action="{{ route('employees.update', $employee->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label for="name">Nama:</label>
    <input type="text" name="name" id="name" value="{{ $employee->name }}" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="{{ $employee->email }}" required>
    <br>
    <label for="position">Jabatan:</label>
    <input type="text" name="position" id="position" value="{{ $employee->position }}" required>
    <br>
    <label for="salary">Gaji:</label>
    <input type="text" name="salary" id="salary" value="{{ $employee->salary }}" required>
    <br>
    <button type="submit">Update</button>
</form>
@endsection
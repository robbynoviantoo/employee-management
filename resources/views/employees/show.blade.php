@extends('layouts.app')

@section('content')
<h1>Detail Karyawan</h1>
<p>Nama: {{ $employee->Nama }}</p>
<p>Email: {{ $employee->email }}</p>
<p>Jabatan: {{ $employee->position }}</p>
<p>Gaji: {{ $employee->salary }}</p>
<a href="{{ route('employees.edit', $employee->id) }}">Edit</a>
<form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit">Hapus</button>
</form>
@endsection
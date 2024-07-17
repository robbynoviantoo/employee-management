@extends('layouts.app')

@section('title', 'Detail Karyawan')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Detail Karyawan</h4>
            </div>
            <div class="card-body">

                <h5 class="card-title text-center" style="font-size: 2rem;">{{ $employee->name }}</h5>
                <div class="row mb-2">
                    <div class="col-md-3 font-weight-bold">NIK</div>
                    <div class="col-md-9">: {{ $employee->nik }}</div>
                </div>
                @if ($employee->photo)
                    <img src="{{ asset('images/' . $employee->photo) }}" class="img-thumbnail mb-3 d-block mx-auto"
                        alt="Foto Karyawan" style="max-width: 400px; height: auto;">
                @else
                    <p class="text-center">No photo available</p>
                @endif
                <div class="row mb-2">
                    <div class="col-md-3 font-weight-bold">Jabatan</div>
                    <div class="col-md-9">: {{ $employee->position }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3 font-weight-bold">Gedung</div>
                    <div class="col-md-9">: {{ $employee->building }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3 font-weight-bold">Area</div>
                    <div class="col-md-9">: {{ $employee->area }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3 font-weight-bold">Cell</div>
                    <div class="col-md-9">: {{ $employee->cell }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3 font-weight-bold">ID Pass</div>
                    <div class="col-md-9">: {{ $employee->idpass }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3 font-weight-bold">Telepon</div>
                    <div class="col-md-9">: {{ $employee->phone }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3 font-weight-bold">Tanggal Masuk</div>
                    <div class="col-md-9">: {{ $employee->datein }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3 font-weight-bold">Status</div>
                    <div class="col-md-9">: {{ $employee->status }}</div>
                </div>
                <div class="text-center">
                    <a href="{{ route('employees.index') }}" class="btn btn-primary mt-3">Kembali ke Daftar Karyawan</a>
                    <a href="https://wa.me/+62{{ $employee->phone }}" class="btn btn-success mt-3" target="_blank">Hubungi
                        via WhatsApp</a>
                </div>
            </div>
        </div>
    </div>
@endsection

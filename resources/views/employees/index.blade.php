@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="container-fluid mt-5">
        <h1 class="mb-4">INFORMATION</h1>
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card">
                    <div class="card-header">Jumlah Karyawan</div>
                    <div class="card-body">
                        <h1 class="card-title">{{ $employeeCount }}</h1>
                        <p class="card-text">Total karyawan yang terdaftar.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card">
                    <div class="card-header">Karyawan Aktif</div>
                    <div class="card-body">
                        <h1 class="card-title">{{ $activeEmployeeCount }}</h1>
                        <p class="card-text">Total karyawan yang aktif.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card">
                    <div class="card-header">Karyawan Resign</div>
                    <div class="card-body">
                        <h1 class="card-title">{{ $resignedEmployeeCount }}</h1>
                        <p class="card-text">Total karyawan yang telah resign.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card">
                    <div class="card-header">Karyawan Resign Bulan Ini</div>
                    <div class="card-body">
                        <h1 class="card-title">{{ number_format($resignedPercentageCurrentMonth, 2) }}%</h1>
                        <p class="card-text">Persentase karyawan yang resign bulan ini.</p>
                    </div>
                </div>
            </div>
        </div>

        <h1 class="mb-4">LIST KARYAWAN</h1>

        <div class="d-flex flex-column flex-md-row justify-content-between mb-3">
            <form action="{{ route('employees.filter') }}" method="GET" class="d-flex mb-2 mb-md-0">
                <select id="position-filter" name="position" class="form-control w-auto mr-2">
                    <option value="all">All Jabatan</option>
                    @foreach ($positions as $position)
                        <option value="{{ $position }}"
                            {{ old('position', $currentPosition) == $position ? 'selected' : '' }}>{{ $position }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Apply Filter</button>
            </form>
            <div class="d-flex flex-column flex-md-row">
                <a href="{{ route('monthly_employee_data.index') }}" class="btn btn-info mb-2 mb-md-0 mr-md-2">Lihat
                    Persentase Resign Bulanan</a>
                <a href="{{ route('import.form') }}" class="btn btn-warning mb-2 mb-md-0 mr-md-2">Import from Excel</a>
                <a href="{{ route('employees.export') }}" class="btn btn-success mb-2 mb-md-0">Export to Excel</a>
            </div>
        </div>

        <div class="table-responsive">
            <table id="employees-table" class="table table-striped table-bordered text-center" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Foto</th>
                        <th>Jabatan</th>
                        <th>Gedung</th>
                        <th>Area</th>
                        <th>Cell</th>
                        <th>ID Pass</th>
                        <th>No.Handphone</th>
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Resign</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $index => $employee)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $employee->nik }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>
                                <img src="{{ $employee->photo ? asset('storage/' . $employee->photo) : asset('images/default-photo.png') }}"
                                    alt="Foto" width="50">
                            </td>
                            <td>{{ $employee->position }}</td>
                            <td>{{ $employee->building }}</td>
                            <td>{{ $employee->area }}</td>
                            <td>{{ $employee->cell }}</td>
                            <td>{{ $employee->idpass }}</td>
                            <td>{{ $employee->phone }}</td>
                            <td>{{ \Carbon\Carbon::parse($employee->datein)->format('d-m-Y') }}</td>
                            @if ($employee->dateout)
                                <td>{{ \Carbon\Carbon::parse($employee->dateout)->format('d-m-Y') }}</td>
                            @else
                                <td>-</td>
                            @endif
                            <td>
                                <span
                                    class="{{ $employee->status == 'On Work' ? 'text-success font-weight-bold' : 'text-danger font-weight-bold' }}">
                                    {{ $employee->status }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('employees.show', ['id' => $employee->id]) }}"
                                        class="btn btn-primary btn-sm mr-1">Lihat</a>
                                    <a href="{{ route('employees.edit', ['id' => $employee->id]) }}"
                                        class="btn btn-warning btn-sm mr-1">Edit</a>
                                    <form action="{{ route('employees.destroy', ['id' => $employee->id]) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <script>
            $(document).ready(function() {
                var table = $('#employees-table').DataTable({
                    "columnDefs": [{
                        "searchable": false,
                        "orderable": false,
                        "targets": 0 // Target kolom nomor urut
                    }],
                    "order": [
                        [1, 'asc']
                    ] // Mengurutkan berdasarkan kolom nama (index 1)
                });

                // Mengatur nomor urut
                table.on('order.dt search.dt', function() {
                    table.column(0, {
                        search: 'applied',
                        order: 'applied'
                    }).nodes().each(function(cell, i) {
                        cell.innerHTML = i + 1;
                    });
                }).draw();
            });
        </script>
    @endsection

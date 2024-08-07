@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="container-fluid mt-5 ">
        <h1 class="mb-4 header-title">INFORMATION</h1>
        <div class="row mb-4">
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="card h-100 costum-rounded">
                    <div class="card-header">Jumlah Karyawan</div>
                    <div class="card-body">
                        <h1 class="card-title animate-text">{{ $employeeCount }}</h1>
                        <p class="card-text subtitle">
                            Peningkatan vs bulan lalu
                            @if ($employeeChange > 0)
                                <span class="text-success animate-text">
                                    <i class="fas fa-arrow-up"></i> {{ number_format($employeeChangePercentage, 2) }}%
                                </span>
                            @elseif ($employeeChange < 0)
                                <span class="text-danger animate-text">
                                    <i class="fas fa-arrow-down"></i> {{ number_format($employeeChangePercentage, 2) }}%
                                </span>
                            @else
                                <span class="animate-text">{{ number_format($employeeChangePercentage, 2) }}%</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="card h-100 costum-rounded">
                    <div class="card-header">Karyawan Aktif</div>
                    <div class="card-body">
                        <h1 class="card-title animate-text">{{ $activeEmployeeCount }}</h1>
                        <p class="card-text subtitle">Total karyawan yang aktif.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="card h-100 costum-rounded">
                    <div class="card-header">Karyawan Resign</div>
                    <div class="card-body">
                        <h1 class="card-title animate-text">{{ $resignedEmployeeCount }}</h1>
                        <p class="card-text subtitle">Total karyawan yang telah resign.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="card h-100 costum-rounded">
                    <div class="card-header">Karyawan Resign Bulan Ini</div>
                    <div class="card-body">
                        <h1 class="card-title animate-text">{{ number_format($resignedPercentageCurrentMonth, 2) }}%</h1>
                        <p class="card-text subtitle">Persentase karyawan yang resign bulan ini.</p>
                    </div>
                </div>
            </div>
        </div>

        <h1 class="mb-4 header-title">LIST KARYAWAN</h1>
        <div class="section-table mb-5">
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
                    <a href="{{ route('monthly_employee_data.index') }}" class="btn btn-danger mb-2 mb-md-0 mr-md-2">Lihat
                        Persentase</a>
                    <a href="{{ route('import.form') }}" class="btn btn-warning mb-2 mb-md-0 mr-md-2">Import from Excel</a>
                    <a href="{{ route('employees.export') }}" class="btn btn-success mb-2 mb-md-0 mr-md-2">Export to
                        Excel</a>
                    {{-- <a href="{{ route('employees.deleteDuplicates') }}" class="btn btn-danger mb-2 mb-md-0">Hapus Duplikat</a> --}}
                </div>
            </div>

            <div class="table-responsive mb-2">
                <table id="employees-table" class="table table-striped table-bordered text-center bg-light"
                    style="width:100%">
                    <thead class="">
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
                                <td><a href="{{ route('training.index', $employee->nik) }}">{{ $employee->nik }}</a></td>
                                <td>{{ $employee->name }}</td>
                                <td>
                                    <img src="{{ $employee->photo ? asset('storage/app/public/' . $employee->photo) : asset('public/images/default-photo.png') }}"
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
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('employees.show', $employee->nik) }}" 
                                            class="btn btn-info btn-sm mr-1" data-format='[
                                                {"label": "Photo", "key": "photo"},
                                                {"label": "NIK", "key": "nik"},
                                                {"label": "Nama", "key": "name"},
                                                {"label": "Jabatan", "key": "position"},
                                                {"label": "Gedung", "key": "building"},
                                                {"label": "Area", "key": "area"},
                                                {"label": "Cell", "key": "cell"},
                                                {"label": "ID Pass", "key": "idpass"},
                                                {"label": "No.Handphone", "key": "phone"},
                                                {"label": "Tanggal Masuk", "key": "datein"},
                                                {"label": "Tanggal Resign", "key": "dateout"},
                                                {"label": "Status", "key": "status"}]'>Lihat</a>
                                        @auth
                                            <a href="{{ route('employees.edit', ['nik' => $employee->nik]) }}"
                                                class="btn btn-warning btn-sm mr-1">Edit</a>
                                        <form action="{{ route('employees.destroy', ['nik' => $employee->nik]) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                        @endauth
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <script>
            var imageBaseUrl = "{{ asset('storage/app/public/') }}";
        </script>
    @endsection
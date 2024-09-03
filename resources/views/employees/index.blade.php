@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <style>
        .card-container {
            width: 100%;
            max-width: 300px;
            /* Atur lebar maksimum kartu */
            margin-bottom: 20px;
            display: inline-block;
        }

        .card {
            height: 100%;
            background-image: url('public/images/card1.png');
            background-size: cover;
            background-position: center;
            border-radius: 10px;
            /* Sesuaikan radius sesuai kebutuhan */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            border: 0px;

        }

        /* Kartu 1 */
        .card1 {
            background-image: url('public/images/card1.png');
            /* atau gunakan warna */
        }

        /* Kartu 2 */
        .card2 {
            background-image: url('public/images/card2.png');
        }

        /* Kartu 3 */
        .card3 {
            background-image: url('public/images/card3.png');
        }

        /* Kartu 4 */
        .card4 {
            background-image: url('public/images/card4.png');
        }

        .card-header {
            color: #fff;
            padding-left: 20px;
            padding-top: 20px;
            font-size: 18px;
            border: 1px;
            font-weight: 400;
            background-color: #dddddd00
        }

        .card-body {
            padding-left: 20px;
            color: #fff;
            padding-top: 5px;
        }

        .card-title {
            font-size: 36px;
            margin: 0;
        }

        .subtitle {
            font-size: 14px;
            margin-top: 10px;
            color: #ddd;
        }

        .animate-text {
            /* Anda bisa menambahkan animasi di sini */
        }

        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 10;
            /* Sit on top */
            padding-top: 100px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.9);
            /* Black background with opacity */
        }

        .modal-content {
            margin: auto;
            display: block;
            max-width: 550px;
            margin-bottom: 40px;
        }

        .close {
            position: absolute;
            top: 20px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
    </style>
    <div class="container-fluid mt-4 ">
        <h1 class="header-title mb-4">INFORMASI</h1>
        <div class="row mb-4">
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="card h-100 costum-rounded card1">
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
                <div class="card h-100 costum-rounded card2">
                    <div class="card-header">Karyawan Aktif</div>
                    <div class="card-body">
                        <h1 class="card-title animate-text">{{ $activeEmployeeCount }}</h1>
                        <p class="card-text subtitle">Total karyawan yang aktif.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="card h-100 costum-rounded card3">
                    <div class="card-header">Karyawan Resign</div>
                    <div class="card-body">
                        <h1 class="card-title animate-text">{{ $resignedEmployeeCount }}</h1>
                        <p class="card-text subtitle">Total karyawan yang telah resign.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="card h-100 costum-rounded card4">
                    <div class="card-header">Karyawan Resign Bulan Ini</div>
                    <div class="card-body">
                        <h1 class="card-title animate-text">{{ number_format($resignedPercentageCurrentMonth, 2) }}%</h1>
                        <p class="card-text subtitle">Persentase karyawan yang resign bulan ini.</p>
                    </div>
                </div>
            </div>
            <div class="oke">
                <div class="section-table mt-3 mb-3">
                    <div class="d-flex flex-column flex-md-row justify-content-between mb-3">
                        <form action="{{ route('employees.filter') }}" method="GET"
                            class="d-flex mb-2 mb-md-0 align-items-center">
                            <select id="position-filter" name="position" class="form-select"
                                style="width: auto; margin-right: 10px;">
                                <option value="all">All Jabatan</option>
                                @foreach ($positions as $position)
                                    <option value="{{ $position }}"
                                        {{ old('position', $currentPosition) == $position ? 'selected' : '' }}>
                                        {{ $position }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">Apply Filter</button>
                        </form>
                        <div class="d-flex flex-column flex-md-row">
                            <a href="{{ route('monthly_employee_data.index') }}"
                                class="btn btn-danger mb-2 btn-group">Lihat
                                Persentase</a>
                            <a href="{{ route('import.form') }}" class="btn btn-warning mb-2 btn-group">Import from
                                Excel</a>
                            <a href="{{ route('employees.export') }}" class="btn btn-success mb-2 btn-group">Export to
                                Excel</a>
                            {{-- <a href="{{ route('employees.deleteDuplicates') }}" class="btn btn-danger mb-2 btn-group">Hapus Duplikat</a> --}}
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
                                    <th>Tanggal Lahir</th>
                                    <th>Gender</th>
                                    <th>Foto</th>
                                    <th>Jabatan</th>
                                    <th>Gedung</th>
                                    <th>Area</th>
                                    <th>Cell</th>
                                    <th>ID Pass</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $index => $employee)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><a
                                                href="{{ route('trainings.show', $employee->nik) }}">{{ $employee->nik }}</a>
                                        </td>
                                        <td>{{ $employee->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($employee->tanggallahir)->format('d-m-Y') }}</td>
                                        <td>{{ $employee->gender }}</td>
                                        <td>
                                            <img src="{{ $employee->photo ? asset('storage/app/public/' . $employee->photo) : asset('public/images/default-photo.png') }}"
                                                alt="Foto" width="70" height="70"
                                                style="object-fit: cover; cursor: pointer;" onclick="openModal(this);">
                                        </td>
                                        <div id="imageModal" class="modal" onclick="closeModal()">
                                            <span class="close" onclick="closeModal()">&times;</span>
                                            <img class="modal-content" id="modalImage">
                                        </div>
                                        <td>{{ $employee->position }}</td>
                                        <td>{{ $employee->building }}</td>
                                        <td>{{ $employee->area }}</td>
                                        <td>{{ $employee->cell }}</td>
                                        <td>{{ $employee->idpass }}</td>
                                        <td>{{ \Carbon\Carbon::parse($employee->datein)->format('d-m-Y') }}</td>
                                        {{-- @if ($employee->dateout)
                                        <td>{{ \Carbon\Carbon::parse($employee->dateout)->format('d-m-Y') }}</td>
                                    @else
                                        <td>-</td>
                                    @endif --}}
                                        <td>
                                            <span
                                                class="{{ $employee->status == 'On Work' ? 'text-success font-weight-bold' : 'text-danger font-weight-bold' }}">
                                                {{ $employee->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('employees.show', $employee->nik) }}"
                                                    class="btn btn-info btn-sm" style="margin-right: 5px;"
                                                    data-format='[
                                                {"label": "Photo", "key": "photo"},
                                                {"label": "NIK", "key": "nik"},
                                                {"label": "Nama", "key": "name"},
                                                {"label": "Tanggal Lahir", "key": "tanggallahir"},
                                                {"label": "Gender", "key": "gender"},
                                                {"label": "Jabatan", "key": "position"},
                                                {"label": "Gedung", "key": "building"},
                                                {"label": "Area", "key": "area"},
                                                {"label": "Cell", "key": "cell"},
                                                {"label": "ID Pass", "key": "idpass"},
                                                @auth
{"label": "No.Handphone", "key": "phone"}, @endauth
                                                {"label": "Tanggal Masuk", "key": "datein"},
                                                {"label": "Tanggal Resign", "key": "dateout"},
                                                {"label": "Status", "key": "status"}]'>Lihat</a>
                                                @auth
                                                    <a href="{{ route('employees.edit', ['nik' => $employee->nik]) }}"
                                                        class="btn btn-warning btn-sm" style="margin-right: 5px;">Edit</a>
                                                    <form action="{{ route('employees.destroy', ['nik' => $employee->nik]) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="confirmDelete(event)">Hapus</button>
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
            </div>
            <script>
                var imageBaseUrl = "{{ asset('storage/app/public/') }}";

                function openModal(image) {
                    var modal = document.getElementById("imageModal");
                    var modalImg = document.getElementById("modalImage");
                    modal.style.display = "block";
                    modalImg.src = image.src;
                }

                function closeModal() {
                    var modal = document.getElementById("imageModal");
                    modal.style.display = "none";
                }
            </script>
        @endsection

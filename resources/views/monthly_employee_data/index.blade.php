@extends('layouts.app')

@section('title', 'Data Karyawan Resign per Bulan')

@section('content')
<div class="container">
    <h1 class="my-4">Data Karyawan Resign per Bulan</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @php
        function getMonthName($monthNumber) {
            $months = [
                1 => 'Januari',
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember'
            ];
            return $months[$monthNumber];
        }

        function getEmployeeChange($currentMonthData, $previousMonthData) {
            if ($previousMonthData) {
                return $currentMonthData->total_employees - $previousMonthData->total_employees;
            }
            return 'N/A';
        }
    @endphp

    <div class="mb-3">
        <a href="{{ route('employees.index') }}" class="btn btn-primary">Kembali ke Daftar Karyawan</a>
    </div>

    <div class="mb-3">
        <form method="GET" action="{{ route('monthly_employee_data.index') }}">
            <div class="form-row">
                <div class="col-md-4">
                    <select name="year" class="form-control">
                        <option value="">Pilih Tahun</option>
                        @foreach ($years->sort() as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="month" class="form-control mt-md-0 mt-2">
                        <option value="">Pilih Bulan</option>
                        @foreach (range(1, 12) as $month)
                            <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>{{ getMonthName($month) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-center">
                    <button type="submit" class="btn btn-primary mr-2">Filter</button>
                    <a href="{{ route('monthly_employee_data.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <div class="mb-3">
        <button id="processCommand" class="btn btn-success">Proses Perintah</button>
    </div>

    <div class="table-responsive">
        <table id="employeeTable" class="table table-striped table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Tahun</th>
                    <th>Bulan</th>
                    <th>Total Karyawan</th>
                    <th>Perubahan Karyawan</th>
                    <th>Total Karyawan Aktif</th>
                    <th>Karyawan Resign</th>
                    <th>Persentase Resign</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $previousMonthData = null;
                @endphp
                @foreach ($monthlyData as $data)
                    <tr>
                        <td>{{ $data->year }}</td>
                        <td>{{ getMonthName($data->month) }}</td>
                        <td>{{ $data->total_employees }}</td>
                        <td>{{ getEmployeeChange($data, $previousMonthData) }}</td>
                        <td>{{ $data->active_employees }}</td>
                        <td>{{ $data->resigned_employees }}</td>
                        <td>{{ $data->total_employees > 0 ? number_format(($data->resigned_employees / $data->total_employees) * 100, 2) : 0 }}%</td>
                    </tr>
                    @php
                        $previousMonthData = $data;
                    @endphp
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#employeeTable').DataTable({
            "pageLength": 12,
            "order": [[0, "desc"]] // Mengurutkan kolom pertama (Tahun) secara descending
        });

        $('#processCommand').click(function() {
            $.ajax({
                url: '{{ route('artisan.command') }}',
                method: 'POST',
                data: {
                    command: 'update:monthly-employee-data {{ request ('year') }}',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert('Perintah berhasil diproses!');
                },
                error: function(response) {
                    alert('Terjadi kesalahan saat memproses perintah.');
                }
            });
        });
    });
</script>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Data Karyawan Bulanan</h1>

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
    @endphp

    <div class="mb-3">
        <a href="{{ route('employees.index') }}" class="btn btn-primary">Kembali ke Daftar Karyawan</a>
    </div>

    <div class="table-responsive">
        <table id="employeeTable" class="table table-striped table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Tahun</th>
                    <th>Bulan</th>
                    <th>Total Karyawan</th>
                    <th>Karyawan Resign</th>
                    <th>Persentase Resign</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($monthlyData as $data)
                    <tr>
                        <td>{{ $data->year }}</td>
                        <td>{{ getMonthName($data->month) }}</td>
                        <td>{{ $data->total_employees }}</td>
                        <td>{{ $data->resigned_employees }}</td>
                        <td>{{ number_format(($data->resigned_employees / $data->total_employees) * 100, 2) }}%</td>
                    </tr>
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
            "pageLength": 12
        });
    });
</script>
@endsection
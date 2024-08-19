@extends('layouts.app')

@section('title', 'STO')

@section('content')
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px; /* Spacing between tables */
        }
        .table-wrapper {
            flex: 1 1 300px; /* Allow tables to grow and shrink, with a base width of 300px */
            max-width: 300px; /* Set maximum width for the table wrapper */
            overflow-x: auto; /* Allow horizontal scroll if necessary */
        }
        table {
            width: 100%; /* Ensure the table takes full width of its container */
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        thead td {
            font-weight: bold;
            background-color: #f2f2f2;
        }
        .header h2 {
            margin: 0;
        }
        .view-link {
            text-decoration: none;
            color: #007bff;
        }
        .view-link:hover {
            text-decoration: underline;
        }
        .total-row {
            font-weight: bold;
            background-color: #f2f2f2;
        }

        @media (max-width: 768px) {
            .table-wrapper{
                width: 100%;
            }
        }
        @media (max-width: 480px) {
            .table-wrapper{
                width: 100%;
            }
        }
    </style>
<body>
    <div class="container mt-5 section-table">
        <div class="container header mt-1">
            <h2>Struktur Organisasi</h2>
        </div>
        @foreach ($buildings as $building)
            @if (isset($employeeCounts[$building]) && !empty($employeeCounts[$building]))
                @php
                    $totalCount = array_sum($employeeCounts[$building]); // Calculate the total count for the building
                @endphp
                <div class="table-wrapper">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <td colspan="2">
                                    Building {{ $building }} 
                                    <a href="{{ route('building.view', ['building' => $building]) }}" class="view-link">View</a>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employeeCounts[$building] as $position => $count)
                                <tr>
                                    <td>{{ $position }}</td>
                                    <td>{{ $count }}</td>
                                </tr>
                            @endforeach
                            <tr class="total-row">
                                <td>Total</td>
                                <td>{{ $totalCount }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        @endforeach
    </div>
</body>
@endsection

@extends('layouts.app')

@section('title', 'Detail STO Building')

@section('content')
    <style>
        .position-group {
            margin-bottom: 20px;
        }
        .position-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center; /* Center the text */
        }
        .card-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 10px; /* Spacing between cards */
            justify-content: center; /* Center the cards horizontally */
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 10px !important;
            padding: 10px;
            width: 180px;
            height: 320px; /* Slightly wider for better image fit */
            display: flex;
            flex-direction: column;
            align-items: center; /* Center items horizontally */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transition for hover effects */
        }
        .card:hover {
            transform: scale(1.05); /* Slightly scale up the card on hover */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Increase shadow on hover */
        }
        .card img {
            width: 150px; /* Larger image size */
            height: 160px;
            border-radius: 2%;
            object-fit: cover; /* Ensure the image is not distorted */
            margin-bottom: 10px; /* Space between image and text */
            transition: opacity 0.3s ease; /* Smooth transition for image hover effect */
        }
        .card:hover img {
            opacity: 0.8; /* Slightly fade the image on hover */
        }
        .card-content {
            text-align: center; /* Center text within the card */
        }
        .card-title {
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .card-subtitle {
            color: #555;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .card-wrapper {
                gap: 10px; /* Reduce the gap between cards on smaller screens */
            }
            .card {
                width: 45%; /* Adjust card width for smaller screens */
                
            }

            .card img {
            width: 140px; /* Larger image size */
            height: 150px;
        }

        }
        @media (max-width: 480px) {
            .card {
                width: 45%; /* Full width for cards on very small screens */
            }
            .card img {
            width: 130px; /* Larger image size */
            height: 140px;
        }
        }
    </style>

<div class="container mt-5">
    <a href="{{ route('sto.index') }}" class="btn-primary" style="text-decoration: none; background-color:#007bff; border:none; padding:10px 20px; border-radius:10px; color:white">Back to List</a>
</div>
    <div class="container mt-5 section-table mb-5">

        @foreach ($positionOrder as $position)
            @php
                $positionEmployees = $employees->filter(function($employee) use ($position) {
                    return $employee->position === $position;
                });
            @endphp

            @if ($positionEmployees->isNotEmpty())
                <div class="position-group">
                    <div class="position-title">{{ $position }}</div>
                    <div class="card-wrapper">
                        @foreach ($positionEmployees as $employee)
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-title">
                                        {{ $employee->cell }}
                                    </div>
                                </div>
                                <a href="{{ route('trainings.show', ['id' => $employee->nik]) }}">
                                    <img src="{{ $employee->photo ? asset('storage/app/public/' . $employee->photo) : asset('public/images/default-photo.png') }}">
                                </a>
                                <div class="card-content">
                                    <div class="card-title">{{ $employee->name }}</div>
                                    <div class="card-subtitle">{{ $employee->position }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endsection

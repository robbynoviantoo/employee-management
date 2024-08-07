@extends('layouts.app')

@section('title', 'Summary Employee')

@section('content')
<div class="container">
    <h1>Training New Comers for NIK: {{ $nik }}</h1>

    @if($trainingData->isEmpty())
        <p>No training data found for this NIK.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Component</th>
                    <th>Introduction</th>
                    <th>Cutting</th>
                    <th>Stitching</th>
                    <th>Assembly</th>
                    <th>2nd Process</th>
                    <th>Report</th>
                    <th>6 & 9 Checkpoint</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trainingData as $training)
                    <tr>
                        <td>{{ $training->component }}</td>
                        <td>{{ $training->introduction }}</td>
                        <td>{{ $training->cutting }}</td>
                        <td>{{ $training->stitching }}</td>
                        <td>{{ $training->assembly }}</td>
                        <td>{{ $training->second_process }}</td>
                        <td>{{ $training->report }}</td>
                        <td>{{ $training->six_and_nine_checkpoint }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
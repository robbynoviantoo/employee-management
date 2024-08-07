@extends('layouts.app')

@section('title', 'Edit Data Training')

@section('content')
    <div class="container">
        <h1 class="mb-4">Edit Data Training untuk NIK {{ $training->first()->nik }}</h1>
        <form action="{{ route('trainings.update', $training->first()->nik) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nik">NIK</label>
                <input type="text" id="nik" name="nik" class="form-control" value="{{ $training->first()->nik }}" readonly>
            </div>

            <h3 class="mt-4">Materi Training</h3>
            <div id="materi-sections">
                @foreach ($materis as $materi)
                    <div class="form-group">
                        <label>{{ $materi->materi_name }}</label>
                        <input type="hidden" name="materis[]" value="{{ $materi->id }}">
                        <div class="form-row">
                            <div class="col">
                                <label for="tanggal_{{ $materi->id }}">Tanggal</label>
                                <input type="date" id="tanggal_{{ $materi->id }}" name="tanggal[{{ $materi->id }}]" class="form-control" value="{{ old('tanggal.' . $materi->id, $materiData[$materi->id]['tanggal']) }}">
                            </div>
                            <div class="col">
                                <label for="first_score_{{ $materi->id }}">1st Score</label>
                                <input type="number" step="0.01" id="first_score_{{ $materi->id }}" name="first_score[{{ $materi->id }}]" class="form-control" value="{{ old('first_score.' . $materi->id, $materiData[$materi->id]['first_score']) }}">
                            </div>
                            <div class="col">
                                <label for="retest_score_{{ $materi->id }}">Retest Score</label>
                                <input type="number" step="0.01" id="retest_score_{{ $materi->id }}" name="retest_score[{{ $materi->id }}]" class="form-control" value="{{ old('retest_score.' . $materi->id, $materiData[$materi->id]['retest_score']) }}">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        </form>
    </div>
@endsection
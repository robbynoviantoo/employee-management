<?php

namespace App\Http\Controllers;

use App\Models\TrainingNewComer;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function index($nik)
    {
        // Ambil data berdasarkan nik
        $trainingData = TrainingNewComer::where('nik', $nik)->get();

        // Kirim data ke view
        return view('training.index', compact('trainingData', 'nik'));
    }
}
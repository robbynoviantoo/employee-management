<?php

namespace App\Http\Controllers;

use App\Exports\TrainingExport;
use App\Models\Training;
use App\Models\Materi;
use App\Models\Employee;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TrainingController extends Controller
{
    public function index()
    {
        // Ambil NIK unik dan ambil data terkait materi
        $trainings = Training::select('nik')
            ->groupBy('nik')
            ->with('materi') // Mengambil data materi terkait
            ->get();
        
        return view('trainings.index', compact('trainings'));
    }

    public function create()
    {
        $employees = Employee::all();
        $materis = Materi::all();
        $kategoriList = Materi::distinct('kategori')->pluck('kategori');
        $defaultKategori = 'Training'; // Default kategori jika ingin ditampilkan pada pemuatan awal
    
        return view('trainings.create', compact('employees', 'materis', 'kategoriList', 'defaultKategori'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|max:255',
            'tanggal' => 'nullable|array',
            'tanggal.*' => 'nullable|date',
            'first_score' => 'nullable|array',
            'first_score.*' => 'nullable|numeric',
            'retest_score' => 'nullable|array',
            'retest_score.*' => 'nullable|numeric',
            'materis' => 'required|array',
            'materis.*' => 'required|exists:materis,id',
        ]);
    
        foreach ($request->materis as $materiId) {
            Training::updateOrCreate(
                [
                    'nik' => $request->nik,
                    'materi_id' => $materiId
                ],
                [
                    'tanggal' => $request->tanggal[$materiId] ?? null,
                    'first_score' => $request->first_score[$materiId] ?? null,
                    'retest_score' => $request->retest_score[$materiId] ?? null,
                ]
            );
        }
    
        return redirect()->route('trainings.index')->with('success', 'Data training berhasil ditambahkan.');
    }

    public function show($id)
    {
        // Ambil data karyawan berdasarkan ID
        $employee = Employee::findOrFail($id);
    
        // Ambil data training yang terkait dengan karyawan
        $trainingData = Training::where('nik', $id)->get();
    
        // Ambil materi dan kategori
        $materis = Materi::all();
    
        // Dapatkan kategori unik dari materi
        $categories = $materis->pluck('kategori')->unique();
    
        // Kirim data ke tampilan
        return view('trainings.show', compact('employee', 'trainingData', 'materis', 'categories'));
    }
    

    public function edit($id)
    {
        // Ambil data training berdasarkan ID
        $training = Training::where('nik', $id)->get(); // Mengambil semua data training untuk NIK tertentu
        $employees = Employee::all(); // Ambil semua data employee
        $materis = Materi::all(); // Ambil semua data materi
        $kategoriList = Materi::distinct('kategori')->pluck('kategori');
        $defaultKategori = 'Training'; // Default kategori jika ingin ditampilkan pada pemuatan awal
    
        // Format data materi untuk ditampilkan di form edit
        $materiData = [];
        foreach ($materis as $materi) {
            // Ambil data training untuk materi tertentu
            $trainingForMateri = $training->firstWhere('materi_id', $materi->id);
    
            $materiData[$materi->id] = [
                'tanggal' => $trainingForMateri->tanggal ?? null,
                'first_score' => $trainingForMateri->first_score ?? null,
                'retest_score' => $trainingForMateri->retest_score ?? null,
            ];
        }
    
        return view('trainings.edit', compact('training', 'employees', 'materis', 'materiData','kategoriList','defaultKategori'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nik' => 'required|string|exists:employees,nik',
            'materis.*' => 'required|exists:materis,id',
            'tanggal.*' => 'nullable|date',
            'first_score.*' => 'nullable|numeric|min:0|max:100',
            'retest_score.*' => 'nullable|numeric|min:0|max:100',
        ]);
    
        $nik = $request->input('nik');
        $materis = $request->input('materis');
        $dates = $request->input('tanggal', []);
        $firstScores = $request->input('first_score', []);
        $retestScores = $request->input('retest_score', []);
    
        foreach ($materis as $materi_id) {
            Training::updateOrCreate(
                ['nik' => $nik, 'materi_id' => $materi_id],
                [
                    'tanggal' => isset($dates[$materi_id]) ? $dates[$materi_id] : null,
                    'first_score' => isset($firstScores[$materi_id]) ? $firstScores[$materi_id] : null,
                    'retest_score' => isset($retestScores[$materi_id]) ? $retestScores[$materi_id] : null,
                ]
            );
        }
    
        return redirect()->route('trainings.index')->with('success', 'Data training berhasil diperbarui.');
    }

    public function destroy(Training $training)
    {
        $training->delete();
        return redirect()->route('trainings.index')->with('success', 'Data training berhasil dihapus.');
    }

    public function export() 
    {
        return Excel::download(new TrainingExport, 'users.xlsx');
    }
}
<?php

namespace App\Http\Controllers;

use App\Exports\TrainingExport;
use App\Imports\TrainingImport;
use App\Models\Absence;
use App\Models\ChangeLog;
use App\Models\Training;
use App\Models\Materi;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // Validasi input
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
    
        $userId = Auth::id(); // Mendapatkan ID pengguna yang saat ini sedang login
    
        // Simpan data lama untuk perbandingan
        $oldTrainings = Training::where('nik', $request->nik)
                                ->whereIn('materi_id', $request->materis)
                                ->get()
                                ->keyBy('materi_id');
    
        // Menyimpan data yang akan diubah
        $changedEntries = [];
    
        foreach ($request->materis as $materiId) {
            // Ambil data lama
            $training = $oldTrainings->get($materiId);
            $oldValues = $training ? $training->getAttributes() : [];
    
            // Update atau buat data training baru
            $training = Training::updateOrCreate(
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
    
            // Catat perubahan hanya jika data lama ada (update) atau jika data baru dibuat
            if ($training->wasRecentlyCreated) {
                $changedEntries[] = [
                    'change_type' => 'INSERT',
                    'old_value' => null,
                    'new_value' => json_encode([
                        'materi_id' => $materiId,
                        'tanggal' => $request->tanggal[$materiId] ?? null,
                        'first_score' => $request->first_score[$materiId] ?? null,
                        'retest_score' => $request->retest_score[$materiId] ?? null,
                    ]),
                    'user_id' => $userId
                ];
            } elseif ($training->wasChanged()) {
                $changedEntries[] = [
                    'change_type' => 'UPDATE',
                    'old_value' => json_encode($oldValues),
                    'new_value' => json_encode([
                        'materi_id' => $materiId,
                        'tanggal' => $request->tanggal[$materiId] ?? null,
                        'first_score' => $request->first_score[$materiId] ?? null,
                        'retest_score' => $request->retest_score[$materiId] ?? null,
                    ]),
                    'user_id' => $userId
                ];
            }
        }
    
        // Catat entri yang dihapus
        $newMateris = collect($request->materis)->keyBy(fn($item) => $item);
        $deletedMateris = $oldTrainings->keys()->diff($newMateris->keys());
    
        foreach ($deletedMateris as $materiId) {
            $changedEntries[] = [
                'change_type' => 'DELETE',
                'old_value' => json_encode($oldTrainings->get($materiId)->getAttributes()),
                'new_value' => null,
                'user_id' => $userId
            ];
        }
    
        // Simpan semua perubahan ke dalam change_log
        foreach ($changedEntries as $entry) {
            ChangeLog::create([
                'entity_type' => 'training',
                'entity_id' => $request->nik,
                'old_value' => $entry['old_value'],
                'new_value' => $entry['new_value'],
                'change_type' => $entry['change_type'],
                'user_id' => $entry['user_id']
            ]);
        }
    
        return redirect()->route('trainings.index')->with('success', 'Data training berhasil diperbarui.');
    }
    public function show($id)
    {
        // Ambil data karyawan berdasarkan ID
        $employee = Employee::findOrFail($id);
    
        // Ambil data training yang terkait dengan karyawan
        $trainingData = Training::where('nik', $employee->nik)->get();
    
        // Ambil materi dan kategori
        $materis = Materi::all();
        $categories = $materis->pluck('kategori')->unique();
    
        // Ambil absensi untuk karyawan selama satu tahun
        $year = now()->year; // Tahun saat ini
    
        $sickCount = Absence::where('nik', $employee->nik)
                            ->where('alasan', 'Sakit')
                            ->whereYear('tanggal', $year)
                            ->count();
        $alphaCount = Absence::where('nik', $employee->nik)
                             ->where('alasan', 'Alpha')
                             ->whereYear('tanggal', $year)
                             ->count();
        $leaveCount = Absence::where('nik', $employee->nik)
                             ->where('alasan', 'Cuti')
                             ->whereYear('tanggal', $year)
                             ->count();
        $ijinCount = Absence::where('nik', $employee->nik)
                             ->where('alasan', 'Ijin')
                             ->whereYear('tanggal', $year)
                             ->count();
    
        // Kirim data ke tampilan
        return view('trainings.show', compact('employee', 'trainingData', 'materis', 'categories', 'sickCount', 'alphaCount', 'leaveCount','ijinCount'));
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
        // Validasi input
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
        $userId = Auth::id(); // Mendapatkan ID pengguna yang saat ini sedang login
    
        foreach ($materis as $materi_id) {
            $training = Training::where('nik', $nik)->where('materi_id', $materi_id)->first();
    
            // Ambil nilai lama sebelum update
            $oldValues = $training ? $training->getAttributes() : [];
    
            // Update atau buat data training baru
            Training::updateOrCreate(
                ['nik' => $nik, 'materi_id' => $materi_id],
                [
                    'tanggal' => isset($dates[$materi_id]) ? $dates[$materi_id] : null,
                    'first_score' => isset($firstScores[$materi_id]) ? $firstScores[$materi_id] : null,
                    'retest_score' => isset($retestScores[$materi_id]) ? $retestScores[$materi_id] : null,
                ]
            );
    
            // Catat perubahan jika data lama ada
            if ($training) {
                ChangeLog::create([
                    'entity_type' => 'training',
                    'entity_id' => $nik,
                    'old_value' => json_encode($oldValues),
                    'new_value' => json_encode([
                        'materi_id' => $materi_id,
                        'tanggal' => isset($dates[$materi_id]) ? $dates[$materi_id] : null,
                        'first_score' => isset($firstScores[$materi_id]) ? $firstScores[$materi_id] : null,
                        'retest_score' => isset($retestScores[$materi_id]) ? $retestScores[$materi_id] : null,
                    ]),
                    'change_type' => 'UPDATE',
                    'user_id' => $userId
                ]);
            } else {
                // Catat perubahan jika data baru dibuat
                ChangeLog::create([
                    'entity_type' => 'training',
                    'entity_id' => $nik,
                    'new_value' => json_encode([
                        'materi_id' => $materi_id,
                        'tanggal' => isset($dates[$materi_id]) ? $dates[$materi_id] : null,
                        'first_score' => isset($firstScores[$materi_id]) ? $firstScores[$materi_id] : null,
                        'retest_score' => isset($retestScores[$materi_id]) ? $retestScores[$materi_id] : null,
                    ]),
                    'change_type' => 'INSERT',
                    'user_id' => $userId
                ]);
            }
        }
    
        return redirect()->route('trainings.index')->with('success', 'Data training berhasil diperbarui.');
    }

    public function destroy($nik)
    {
        // Retrieve all training records associated with the given NIK
        $trainings = Training::where('nik', $nik)->get();
    
        if ($trainings->isEmpty()) {
            return redirect()->route('trainings.index')->with('error', 'No training records found for this NIK.');
        }
    
        $userId = Auth::id(); // Get the ID of the currently logged-in user
    
        // Log the deletion of each training record
        foreach ($trainings as $training) {
            $oldValues = $training->getAttributes();
            $training->delete();
    
            // Log the deletion in the change log
            ChangeLog::create([
                'entity_type' => 'training',
                'entity_id' => $nik,
                'old_value' => json_encode($oldValues),
                'new_value' => null,
                'change_type' => 'DELETE',
                'user_id' => $userId
            ]);
        }
    
        return redirect()->route('trainings.index')->with('success', 'All training records for the specified NIK have been deleted.');
    }

    public function export() 
    {
        return Excel::download(new TrainingExport, 'users.xlsx');
    }

    public function trainingForm()
    {
        return view('trainings.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new TrainingImport, $request->file('file'));

        return redirect('/')->with('success', 'Data karyawan berhasil diimpor.');
    }
}
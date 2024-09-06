<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absence;
use App\Models\Employee;

class AbsenceController extends Controller
{
    public function index()
    {
        // Mengurutkan absensi berdasarkan tanggal terbaru (desc) dan filter tahun berjalan
        $absences = Absence::with('employee')
            ->whereYear('tanggal', now()->year)
            ->orderBy('tanggal', 'desc') // Urutkan berdasarkan tanggal terbaru
            ->get();

        // Ambil semua data karyawan untuk dropdown NIK
        $employees = Employee::all();

        return view('absences.index', compact('absences', 'employees'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nik' => 'required|string|exists:employees,nik',
            'alasan' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        Absence::create([
            'tanggal' => $request->tanggal,
            'nik' => $request->nik,
            'alasan' => $request->alasan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Absensi berhasil disimpan');
    }

    public function edit($id)
    {
        $absence = Absence::findOrFail($id);
        $employees = Employee::all();
        return view('absences.edit', compact('absence', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nik' => 'required',
            'alasan' => 'required',
            'keterangan' => 'nullable|string',
        ]);

        $absence = Absence::findOrFail($id);
        $absence->update($request->all());

        return redirect()->route('absences.index')->with('success', 'Absensi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $absence = Absence::findOrFail($id);
        $absence->delete();

        return redirect()->route('absences.index')->with('success', 'Absensi berhasil dihapus.');
    }
}

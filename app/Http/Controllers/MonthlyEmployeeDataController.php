<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MonthlyEmployeeData;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

class MonthlyEmployeeDataController extends Controller
{
    public function index(Request $request)
    {
        $years = MonthlyEmployeeData::selectRaw('DISTINCT year')->pluck('year');
        $query = MonthlyEmployeeData::query();

        if ($request->has('year') && $request->year != '') {
            $query->where('year', $request->year);
        }

        if ($request->has('month') && $request->month != '') {
            $query->where('month', $request->month);
        }

        $monthlyData = $query->orderBy('year')->orderBy('month')->get();

        return view('monthly_employee_data.index', [
            'years' => $years,
            'monthlyData' => $monthlyData
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'year' => 'required|integer',
            'month' => 'required|integer',
            'active_employees' => 'required|integer',
            'resigned_employees' => 'required|integer',
        ]);

        // Hitung total karyawan
        $totalEmployees = $validatedData['active_employees'] + $validatedData['resigned_employees'];
        $validatedData['total_employees'] = $totalEmployees;

        MonthlyEmployeeData::create($validatedData);

        return redirect()->route('monthly_employee_data.index')->with('success', 'Data berhasil disimpan.');
    }

    public function runCommand(Request $request)
    {
        $command = $request->input('command');
        Artisan::call($command);

        return response()->json(['success' => true]);
    }
}
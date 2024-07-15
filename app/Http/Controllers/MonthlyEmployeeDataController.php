<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MonthlyEmployeeData;

class MonthlyEmployeeDataController extends Controller
{
    public function index()
    {
        $monthlyData = MonthlyEmployeeData::orderBy('year', 'asc')
                                          ->orderBy('month', 'asc')
                                          ->get();
        return view('monthly_employee_data.index', compact('monthlyData'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'year' => 'required|integer',
            'month' => 'required|integer',
            'total_employees' => 'required|integer',
            'resigned_employees' => 'required|integer',
        ]);

        MonthlyEmployeeData::create($validatedData);

        return redirect()->route('monthly_employee_data.index')->with('success', 'Data berhasil disimpan.');
    }
}
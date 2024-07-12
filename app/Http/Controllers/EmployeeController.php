<?php

namespace App\Http\Controllers;

use App\Exports\EmployeesExport;
use App\Imports\EmployeesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'photo' => 'required',
            'position' => 'required',
            'building' => 'required',
            'area' => 'required',
            'cell' => 'required',
            'phone' => 'required|numeric',
            'datein' => 'required|date',
            'status' => 'required',
        ]);

        Employee::create($validatedData);
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'photo' => 'required',
            'position' => 'required',
            'building' => 'required',
            'area' => 'required',
            'cell' => 'required',
            'phone' => 'required|numeric',
            'datein' => 'required|date',
            'status' => 'required',
        ]);
        $employee->update($validatedData);
        return redirect()->route('employees.index');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
    
        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil dihapus.');
    }

    public function export()
    {
        $filename = "Employees.xlsx";
        return Excel::download(new EmployeesExport, $filename);
    }

    public function showImportForm()
    {
        return view('employees.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        Excel::import(new EmployeesImport, $request->file('file'));

        return redirect()->route('employees.importForm')->with('success', 'Data Karyawan Berhasil Diimport');
    }
}

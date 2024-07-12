<?php

namespace App\Http\Controllers;

use App\Exports\EmployeesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        $employeeCount = $employees->count();
        $activeEmployeeCount = Employee::where('status', 'On Work')->count();
        $resignedEmployeeCount = Employee::where('status', 'Resigned')->count();

        return view('employees.index', compact('employees', 'employeeCount', 'activeEmployeeCount', 'resignedEmployeeCount'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'position' => 'required',
            'building' => 'required',
            'area' => 'required',
            'cell' => 'required',
            'phone' => 'required|numeric',
            'datein' => 'required|date',
            'status' => 'required',
        ]);

        $employee = new Employee($request->all());

        if ($request->hasFile('photo')) {
            $imageName = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('images'), $imageName);
            $employee->photo = $imageName;
        }

        $employee->save();

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
}

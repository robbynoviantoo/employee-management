<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\EmployeeResource;

class EmployeeController extends Controller
{
    public function index()
    {
        return response()->json(Employee::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|unique:employees,nik',
            'name' => 'required|string',
            'photo' => 'nullable|string',
            'position' => 'nullable|string',
            'building' => 'nullable|string',
            'area' => 'nullable|string',
            'cell' => 'nullable|string',
            'idpass' => 'nullable|string',
            'phone' => 'nullable|string',
            'datein' => 'nullable|date',
            'dateout' => 'nullable|date',
            'status' => 'nullable|string',
        ]);

        $employee = Employee::create($request->all());
        return response()->json($employee, Response::HTTP_CREATED);
    }

    public function show($nik)
    {
        $employee = Employee::findOrFail($nik);
        return response()->json($employee);
    }

    public function update(Request $request, $nik)
    {
        $request->validate([
            'name' => 'nullable|string',
            'photo' => 'nullable|string',
            'position' => 'nullable|string',
            'building' => 'nullable|string',
            'area' => 'nullable|string',
            'cell' => 'nullable|string',
            'idpass' => 'nullable|string',
            'phone' => 'nullable|string',
            'datein' => 'nullable|date',
            'dateout' => 'nullable|date',
            'status' => 'nullable|string',
        ]);

        $employee = Employee::findOrFail($nik);
        $employee->update($request->all());
        return response()->json($employee);
    }

    public function destroy($nik)
    {
        $employee = Employee::findOrFail($nik);
        $employee->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
<?php

namespace App\Http\Controllers;

use App\Exports\EmployeesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $currentPosition = $request->input('position', 'all');
        $query = Employee::query();

        if ($currentPosition && $currentPosition !== 'all') {
            $query->where('position', $currentPosition);
        }

        $employees = $query->get();
        $positions = Employee::select('position')->distinct()->get()->pluck('position');

        // Menghitung persentase karyawan resign tiap bulan
        $resignedPercentages = [];
        for ($month = 1; $month <= 12; $month++) {
            $totalEmployeesThisMonth = Employee::whereYear('datein', '<=', now()->year)
                ->whereMonth('datein', '<=', $month)
                ->count();

            $resignedEmployeesThisMonth = Employee::where('status', 'Resigned')
                ->whereYear('dateout', now()->year)
                ->whereMonth('dateout', $month)
                ->count();

            $resignedPercentage = $totalEmployeesThisMonth > 0 ? ($resignedEmployeesThisMonth / $totalEmployeesThisMonth) * 100 : 0;
            $resignedPercentages[$month] = $resignedPercentage;
        }

        // Menghitung persentase karyawan resign bulan ini
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $totalEmployeesThisCurrentMonth = Employee::whereYear('datein', '<=', $currentYear)
            ->whereMonth('datein', '<=', $currentMonth)
            ->count();

        $resignedEmployeesThisCurrentMonth = Employee::where('status', 'Resigned')
            ->whereYear('dateout', $currentYear)
            ->whereMonth('dateout', $currentMonth)
            ->count();

        $resignedPercentageCurrentMonth = $totalEmployeesThisMonth > 0 ? ($resignedEmployeesThisCurrentMonth / $totalEmployeesThisMonth) * 100 : 0;


        return view('employees.index', [
            'employees' => $employees,
            'positions' => $positions,
            'currentPosition' => $currentPosition,
            'employeeCount' => Employee::count(),
            'activeEmployeeCount' => Employee::where('status', 'On Work')->count(),
            'resignedEmployeeCount' => Employee::where('status', 'Resigned')->count(),
            'resignedPercentages' => $resignedPercentages,
            'resignedPercentageCurrentMonth' => $resignedPercentageCurrentMonth
        ]);
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nik' => 'required',
            'name' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'position' => 'required',
            'building' => 'required',
            'area' => 'required',
            'cell' => 'required',
            'phone' => 'required|numeric',
            'idpass' => 'nullable',
            'datein' => 'required|date',
            'dateout' => 'nullable|date',
            'status' => 'required',
        ]);

        $employee = new Employee($request->all());

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('images', 'public');
            $employee->photo = $path;
        }

        // Atur nilai default untuk dateout jika tidak ada
        if (is_null($employee->dateout)) {
            $employee->dateout = null; // atau nilai default lain yang sesuai
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

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'nik' => 'required|numeric',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'position' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'cell' => 'nullable|string|max:255',
            'phone' => 'required|string|max:15',
            'idpass' => 'nullable',
            'datein' => 'required|date',
            'dateout' => 'nullable|date',
            'status' => 'required|string'
        ]);

        $employee->nik = $request->input('nik');
        $employee->name = $request->input('name');
        $employee->position = $request->input('position');
        $employee->building = $request->input('building');
        $employee->area = $request->input('area');
        $employee->cell = $request->input('cell');
        $employee->phone = $request->input('phone');
        $employee->idpass = $request->input('idpass');
        $employee->datein = $request->input('datein');
        $employee->dateout = $request->input('dateout');
        $employee->status = $request->input('status');

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($employee->photo) {
                Storage::delete('public/' . $employee->photo);
            }

            // Simpan gambar baru
            $path = $request->file('image')->store('images', 'public');
            $employee->photo = $path;
        }

        $employee->save();

        return redirect()->route('employees.index')->with('success', 'Data karyawan berhasil diperbarui.');
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

    public function filter(Request $request)
    {
        $currentPosition = $request->input('position', 'all');
        $query = Employee::query();

        if ($currentPosition && $currentPosition !== 'all') {
            $query->where('position', $currentPosition);
        }

        $employees = $query->get();
        $positions = Employee::select('position')->distinct()->get()->pluck('position');

        // Menghitung persentase karyawan resign tiap bulan
        $resignedPercentages = [];
        for ($month = 1; $month <= 12; $month++) {
            $totalEmployeesThisMonth = Employee::whereYear('datein', '<=', now()->year)
                ->whereMonth('datein', '<=', $month)
                ->count();

            $resignedEmployeesThisMonth = Employee::where('status', 'Resigned')
                ->whereYear('dateout', now()->year)
                ->whereMonth('dateout', $month)
                ->count();

            $resignedPercentage = $totalEmployeesThisMonth > 0 ? ($resignedEmployeesThisMonth / $totalEmployeesThisMonth) * 100 : 0;
            $resignedPercentages[$month] = $resignedPercentage;
        }

        // Menghitung persentase karyawan resign bulan ini
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $totalEmployeesThisCurrentMonth = Employee::whereYear('datein', '<=', $currentYear)
            ->whereMonth('datein', '<=', $currentMonth)
            ->count();

        $resignedEmployeesThisCurrentMonth = Employee::where('status', 'Resigned')
            ->whereYear('dateout', $currentYear)
            ->whereMonth('dateout', $currentMonth)
            ->count();

        $resignedPercentageCurrentMonth = $totalEmployeesThisMonth > 0 ? ($resignedEmployeesThisCurrentMonth / $totalEmployeesThisMonth) * 100 : 0;

        return view('employees.index', [
            'employees' => $employees,
            'positions' => $positions,
            'currentPosition' => $currentPosition,
            'employeeCount' => Employee::count(),
            'activeEmployeeCount' => Employee::where('status', 'On Work')->count(),
            'resignedEmployeeCount' => Employee::where('status', 'Resigned')->count(),
            'resignedPercentages' => $resignedPercentages,
            'resignedPercentageCurrentMonth' => $resignedPercentageCurrentMonth
        ]);
    }

    public function resignMonthly()
    {
        $resignedPercentages = [];
        for ($month = 1; $month <= 12; $month++) {
            $totalEmployeesThisMonth = Employee::whereYear('datein', '<=', now()->year)
                ->whereMonth('datein', '<=', $month)
                ->count();

            $resignedEmployeesThisMonth = Employee::where('status', 'Resigned')
                ->whereYear('dateout', now()->year)
                ->whereMonth('dateout', $month)
                ->count();

            $resignedPercentage = $totalEmployeesThisMonth > 0 ? ($resignedEmployeesThisMonth / $totalEmployeesThisMonth) * 100 : 0;
            $resignedPercentages[$month] = $resignedPercentage;
        }

        return view('employees.resign_monthly', compact('resignedPercentages'));
    }

    // Fungsi untuk menghapus data karyawan yang duplikat
    public function deleteDuplicateEmployees()
    {
        $duplicates = Employee::select('nik')
            ->groupBy('nik')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $duplicate) {
            $duplicateEmployees = Employee::where('nik', $duplicate->nik)->get();

            // Hapus semua kecuali satu entri
            $duplicateEmployees->shift(); // Menghapus entri pertama dari koleksi
            foreach ($duplicateEmployees as $employee) {
                $employee->delete();
            }
        }

        return redirect()->route('employees.index')->with('success', 'Data duplikat berhasil dihapus.');
    }
} 
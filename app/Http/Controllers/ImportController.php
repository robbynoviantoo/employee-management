<?php

namespace App\Http\Controllers;

use App\Imports\EmployeesImport;
use Illuminate\Http\Request;
use App\Imports\UsersImport; // Added this line to import the UsersImport class
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Employee; // Tambahkan ini untuk menggunakan model Employee

class ImportController extends Controller
{
    public function showImportForm()
    {
        return view('import-form');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $import = new EmployeesImport;
        Excel::import($import, $request->file('file'));

        // Memperbarui atau menambahkan data
        foreach ($import->getData() as $row) {
            // Konversi nilai Excel date ke format tanggal yang benar
            $row['datein'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['datein'])->format('Y-m-d');
            if (isset($row['dateout'])) {
                $row['dateout'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['dateout'])->format('Y-m-d');
            }

            Employee::updateOrCreate(
                ['name' => $row['name']], // Pastikan kunci sesuai dengan kolom di file Excel
                $row->toArray() // Konversi Collection ke array
            );
        }

        return redirect()->back()->with('success', 'Data imported successfully.');
    }
}
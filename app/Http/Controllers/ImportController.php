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

            // Konversi Collection ke array
            $rowArray = $row->toArray();

            // Pastikan kunci sesuai dengan kolom di file Excel
            Employee::updateOrCreate(
                ['nik' => $rowArray['nik']],
                [
                    'name' => $rowArray['name'],
                    'photo' => $rowArray['photo'],
                    'position' => $rowArray['position'],
                    'building' => $rowArray['building'],
                    'area' => $rowArray['area'],
                    'cell' => $rowArray['cell'],
                    'idpass' => $rowArray['idpass'] ?? null,
                    'phone' => $rowArray['phone'],
                    'datein' => $rowArray['datein'],
                    'dateout' => $rowArray['dateout'] ?? null,
                    'status' => $rowArray['status'],
                ]
            );
        }

        // Menambahkan pesan notifikasi ke session
        $request->session()->put('success', 'Data karyawan berhasil diimpor.');

        return redirect('/')->with('success', 'Data karyawan berhasil diimpor.');
    }
}
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
        Excel::import(new EmployeesImport, $request->file('file'));
        // Menambahkan pesan notifikasi ke session
        $request->session()->put('success', 'Data karyawan berhasil diimpor.');

        return redirect('/')->with('success', 'Data karyawan berhasil diimpor.');
    }
}
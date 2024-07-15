<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\MonthlyEmployeeDataController;

// Route untuk menampilkan daftar karyawan
Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');

// Route untuk menampilkan form tambah karyawan
Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');

// Route untuk menyimpan data karyawan baru
Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');

// Route untuk menampilkan detail karyawan
Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('employees.show');

// Route untuk menampilkan form edit karyawan
Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');

// Route untuk mengupdate data karyawan
Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');

// Route untuk menghapus data karyawan
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

// Route untuk mengekspor data karyawan
Route::get('/export', [EmployeeController::class, 'export'])->name('employees.export');

// Route untuk menampilkan form impor
Route::get('/import-form', [ImportController::class, 'showImportForm'])->name('import.form');

// Route untuk memproses impor data
Route::post('/import', [ImportController::class, 'import'])->name('import.process');

// Route untuk menampilkan karyawan berdasarkan jabatan yang difilter
Route::get('/employees/', [EmployeeController::class, 'filter'])->name('employees.filter');

// Route untuk mengakses halaman data karyawan bulanan
Route::get('/monthly_employee_data', [MonthlyEmployeeDataController::class, 'index'])->name('monthly_employee_data.index');

// Rute untuk halaman view resign bulanan
Route::get('/resign-monthly', [EmployeeController::class, 'resignMonthly'])->name('employees.resignMonthly');
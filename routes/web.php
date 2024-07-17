<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\MonthlyEmployeeDataController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;

// Route untuk menampilkan daftar karyawan
Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');

// Route untuk menampilkan form tambah karyawan
Route::group(['middleware' => ['auth']], function () {
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
});

// Route untuk menampilkan detail karyawan
Route::get('/employees/{nik}', [EmployeeController::class, 'show'])->name('employees.show');

// Route untuk menampilkan form edit karyawan
Route::get('/employees/{nik}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');

// Route untuk mengupdate data karyawan
Route::put('/employees/{nik}', [EmployeeController::class, 'update'])->name('employees.update');

// Route untuk menghapus data karyawan
Route::delete('/employees/{nik}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

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

// Route untuk menghapus data karyawan yang duplikat
Route::get('/delete-duplicates', [EmployeeController::class, 'deleteDuplicateEmployees'])->name('employees.deleteDuplicates');

// Rute untuk halaman login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

// Rute untuk logout
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
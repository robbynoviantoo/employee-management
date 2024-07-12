<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

// Route untuk menampilkan daftar karyawan
Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');

// Route untuk menampilkan form tambah karyawan
Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');

// Route untuk menyimpan data karyawan baru
Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');

// Route untuk menampilkan detail karyawan
Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');

// Route untuk menampilkan form edit karyawan
Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');

// Route untuk mengupdate data karyawan
Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');

// Route untuk menghapus data karyawan
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

Route::get('/export', [EmployeeController::class, 'export'])->name('employees.export');

Route::get('/employees/import', [EmployeeController::class, 'showImportForm'])->name('employees.importForm');

Route::post('/employees/import', [EmployeeController::class, 'import'])->name('employees.import');
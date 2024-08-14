<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\MonthlyEmployeeDataController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TrainingController;
use Illuminate\Support\Facades\Auth;

// Route for displaying the list of employees
Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');

// Routes for managing employees (requires authentication)
Route::group(['middleware' => ['auth']], function () {
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/{nik}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/{nik}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{nik}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::get('/trainings/create', [TrainingController::class, 'create'])->name('trainings.create');

    // Route to store a newly created training
    Route::post('/trainings', [TrainingController::class, 'store'])->name('trainings.store');

    // Route to display a specific training (show)

    // Route to show the form for editing a specific training
    Route::get('/trainings/{id}/edit', [TrainingController::class, 'edit'])->name('trainings.edit');

    // Route to update a specific training
    Route::put('/trainings/{id}', [TrainingController::class, 'update'])->name('trainings.update');

    // Route to delete a specific training
    Route::delete('/trainings/{id}', [TrainingController::class, 'destroy'])->name('trainings.destroy');
});

// Route for displaying employee details
Route::get('/employees/{nik}', [EmployeeController::class, 'show'])->name('employees.show');

// Route for exporting employee data
Route::get('/export', [EmployeeController::class, 'export'])->name('employees.export');

// Routes for managing training data
Route::get('trainings/export/data', [TrainingController::class, 'export'])->name('trainings.export');
Route::get('/training/form', [TrainingController::class, 'trainingForm'])->name('trainings.form');
Route::post('trainings/import/data', [TrainingController::class, 'import'])->name('trainings.import');

// Routes for import functionality
Route::get('/import-form', [ImportController::class, 'showImportForm'])->name('import.form');
Route::post('/import', [ImportController::class, 'import'])->name('import.process');

// Route for filtering employees based on position
Route::get('/employees/', [EmployeeController::class, 'filter'])->name('employees.filter');

// Route for monthly employee data
Route::get('/monthly_employee_data', [MonthlyEmployeeDataController::class, 'index'])->name('monthly_employee_data.index');

// Route for viewing monthly resignations
Route::get('/resign-monthly', [EmployeeController::class, 'resignMonthly'])->name('employees.resignMonthly');

// Route for deleting duplicate employee data
Route::get('/delete-duplicates', [EmployeeController::class, 'deleteDuplicateEmployees'])->name('employees.deleteDuplicates');

// Routes for authentication
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Default authentication routes
Auth::routes();

// Route for home page after login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route for running artisan commands
Route::post('/artisan-command', [App\Http\Controllers\MonthlyEmployeeDataController::class, 'runCommand'])->name('artisan.command');

// Resource route for training management
Route::get('/trainings', [TrainingController::class, 'index'])->name('trainings.index');
Route::get('/trainings/{id}', [TrainingController::class, 'show'])->name('trainings.show');

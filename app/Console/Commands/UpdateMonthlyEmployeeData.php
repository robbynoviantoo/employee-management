<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use App\Models\MonthlyEmployeeData;
use Carbon\Carbon;

class UpdateMonthlyEmployeeData extends Command
{
    protected $signature = 'update:monthly-employee-data {year?}';
    protected $description = 'Update monthly employee data based on current employee data';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $year = $this->argument('year') ?? Carbon::now()->year;

        for ($month = 1; $month <= 12; $month++) {
            // Hitung jumlah karyawan yang aktif pada awal bulan ini
            $totalEmployees = Employee::where('status', 'On Work')
                                      ->where(function($query) use ($year, $month) {
                                          $query->whereYear('datein', '<', $year)
                                                ->orWhere(function($query) use ($year, $month) {
                                                    $query->whereYear('datein', '=', $year)
                                                          ->whereMonth('datein', '<=', $month);
                                                });
                                      })
                                      ->count();

            // Hitung jumlah karyawan yang resign pada bulan ini
            $resignedEmployees = Employee::where('status', 'Resigned')
                                         ->whereYear('dateout', $year)
                                         ->whereMonth('dateout', $month)
                                         ->count();

            // Simpan atau perbarui data bulanan
            MonthlyEmployeeData::updateOrCreate(
                ['year' => $year, 'month' => $month],
                ['total_employees' => $totalEmployees, 'resigned_employees' => $resignedEmployees]
            );

            $this->info("Monthly employee data for $year-$month updated successfully.");
        }
    }
}
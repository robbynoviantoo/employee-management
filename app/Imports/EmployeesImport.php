<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Konversi nilai Excel date ke format tanggal yang benar
        $tanggallahir = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggallahir'])->format('Y-m-d');
        $datein = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['datein'])->format('Y-m-d');

        // Konversi nilai Excel date untuk dateout jika ada, atau atur null
        $dateout = isset($row['dateout']) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['dateout'])->format('Y-m-d') : null;

        // Gunakan updateOrCreate untuk menghindari duplikasi
        Employee::updateOrCreate(
            ['nik' => $row['nik']],
            [
                'manager_id' => $row['manager_id'],
                'name' => $row['name'],
                'tanggallahir' => $tanggallahir,
                'gender' => $row['gender'],
                'photo' => $row['photo'],
                'position' => $row['position'],
                'building' => $row['building'],
                'area' => $row['area'],
                'cell' => $row['cell'],
                'idpass' => $row['idpass'] ?? null,
                'phone' => $row['phone'],
                'datein' => $datein,
                'dateout' => $dateout,
                'status' => $row['status'],
            ]
        );
    }
}

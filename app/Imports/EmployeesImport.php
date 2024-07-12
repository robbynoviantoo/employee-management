<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Employee([
            'name' => $row['name'],
            'photo' => $row['photo'],
            'position' => $row['position'],
            'building' => $row['building'],
            'area' => $row['area'],
            'cell' => $row['cell'],
            'phone' => $row['phone'],
            'datein' => $row['datein'],
            'status' => $row['status'],
        ]);
    }
}

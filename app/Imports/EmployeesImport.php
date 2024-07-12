<?php

namespace App\Imports;

use App\Models\Employee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EmployeesImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Employee::create([
                'name' => $row['name'],
                'photo' => $row['photo'],
                'position' => $row['position'],
                'building' => $row['building'],
                'area' => $row['area'],
                'cell' => $row['cell'],
                'phone' => $row['phone'],
                'datein' => \Carbon\Carbon::createFromFormat('Y-m-d', $row['datein']),
                'status' => $row['status'],
            ]);
        }
    }

    public function rules(): array
    {
        return [
            '*.name' => ['required', 'string'],
            '*.photo' => ['required', 'string'],
            '*.position' => ['required', 'string'],
            '*.building' => ['required', 'string'],
            '*.area' => ['required', 'string'],
            '*.cell' => ['required', 'string'],
            '*.phone' => ['required', 'string'],
            '*.datein' => ['required', 'date_format:Y-m-d'],
            '*.status' => ['required', 'string'],
        ];
    }
}

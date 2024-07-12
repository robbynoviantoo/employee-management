<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Employee::select('name','photo','position','building','area','cell','phone','datein','status')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'name',
            'photo',
            'position',
            'building',
            'area',
            'cell',
            'phone',
            'datein',
            'status',
        ];
    }

    public function map($employee): array
    {
        static $number = 1;

        return [
            $number++,
            $employee->name,
            $employee->photo,
            $employee->position,
            $employee->building,
            $employee->area,
            $employee->cell,
            $employee->phone,
            $employee->datein,
            $employee->status,
        ];
    }
}
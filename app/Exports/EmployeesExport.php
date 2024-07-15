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
        return Employee::select('nik','name','photo','position','building','area','cell','idpass','phone','datein','status')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'nik',
            'name',
            'photo',
            'position',
            'building',
            'area',
            'cell',
            'idpass',
            'phone',
            'datein',
            'dateout',
            'status',
        ];
    }

    public function map($employee): array
    {
        static $number = 1;

        return [
            $number++,
            $employee->nik,
            $employee->name,
            $employee->photo,
            $employee->position,
            $employee->building,
            $employee->area,
            $employee->cell,
            $employee->idpass,
            $employee->phone,
            $employee->datein,
            $employee->dateout,
            $employee->status,
        ];
    }
}
<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class EmployeesExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    public function collection()
    {
        return Employee::select('nik','name','photo','position','building','area','cell','idpass','phone','datein','dateout','status')->get();
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
            $employee->datein ? \PhpOffice\PhpSpreadsheet\Shared\Date::dateTimeToExcel(new \DateTime($employee->datein)) : null,
            $employee->dateout ? \PhpOffice\PhpSpreadsheet\Shared\Date::dateTimeToExcel(new \DateTime($employee->dateout)) : null,
            $employee->status,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'K' => NumberFormat::FORMAT_DATE_YYYYMMDD, // Kolom 'datein'
            'L' => NumberFormat::FORMAT_DATE_YYYYMMDD, // Kolom 'dateout'
        ];
    }
}
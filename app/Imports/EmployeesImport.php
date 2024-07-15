<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class EmployeesImport implements ToModel, WithHeadingRow, ToCollection
{
    private $data;

    public function collection(Collection $rows)
    {
        $this->data = $rows;
    }

    public function getData()
    {
        return $this->data;
    }

    public function model(array $row)
    {
        // Konversi nilai Excel date ke format tanggal yang benar
        $datein = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['datein'])->format('Y-m-d');

        // Konversi nilai Excel date untuk dateout jika ada, atau atur null
        $dateout = isset($row['dateout']) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['dateout'])->format('Y-m-d') : null;

        return new Employee([
            'nik' => $row['nik'],
            'name' => $row['name'],
            'photo' => $row['photo'],
            'position' => $row['position'],
            'building' => $row['building'],
            'area' => $row['area'],
            'cell' => $row['cell'],
            'idpass' => $row['idpass'] ?? null, // Menangani nilai null
            'phone' => $row['phone'],
            'datein' => $datein, // Menggunakan tanggal yang sudah dikonversi
            'dateout' => $dateout, // Menggunakan tanggal yang sudah dikonversi atau null
            'status' => $row['status'],
        ]);
    }
}
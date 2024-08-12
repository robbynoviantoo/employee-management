<?php

namespace App\Exports;

use App\Models\Training;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class TrainingExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Eager load the related Materi model
        return Training::select('nik', 'materi_id', 'tanggal', 'first_score', 'retest_score')
                       ->with('materi') // Eager load the materi relationship
                       ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'nik',
            'materi_name', // Update the heading to reflect 'materi_name'
            'tanggal',
            'first_score',
            'retest_score',
        ];
    }

    public function map($training): array
    {
        static $number = 1;

        return [
            $number++,
            $training->nik,
            $training->materi ? $training->materi->materi_name : 'N/A', // Get the materi name
            $training->tanggal ? \PhpOffice\PhpSpreadsheet\Shared\Date::dateTimeToExcel(new \DateTime($training->tanggal)) : null,
            $training->first_score,
            $training->retest_score,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_DATE_YYYYMMDD, // Format the date column
        ];
    }
}


<?php

namespace App\Imports;

use App\Models\Training;
use App\Models\Materi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TrainingImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Konversi nilai Excel date ke format tanggal yang benar
        $tanggal = isset($row['tanggal']) 
            ? Date::excelToDateTimeObject($row['tanggal'])->format('Y-m-d')
            : null;

        // Validasi dan konversi nilai score
        $firstScore = isset($row['first_score']) ? (float) $row['first_score'] : null;
        $retestScore = isset($row['retest_score']) ? (float) $row['retest_score'] : null;

        // Cari ID materi berdasarkan nama materi
        $materi = Materi::where('materi_name', $row['materi_name'])->first();
        $materiId = $materi ? $materi->id : null;

        // Gunakan updateOrCreate untuk menghindari duplikasi
        Training::updateOrCreate(
            [
                'nik' => $row['nik'],
                'materi_id' => $materiId
            ],
            [
                'tanggal' => $tanggal,
                'first_score' => $firstScore,
                'retest_score' => $retestScore,
            ]
        );
    }
}

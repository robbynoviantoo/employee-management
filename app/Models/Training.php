<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'materi_id',
        'tanggal',
        'first_score',
        'retest_score',
    ];

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'nik', 'nik');
    }
}

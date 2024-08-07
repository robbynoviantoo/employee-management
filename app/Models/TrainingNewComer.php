<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingNewComer extends Model
{
    protected $fillable = [
        'nik', 'component', 'introduction', 'cutting', 'stitching', 'assembly', 'second_process', 'report', 'six_and_nine_checkpoint'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'nik', 'nik');
    }
}

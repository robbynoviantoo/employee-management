<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
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

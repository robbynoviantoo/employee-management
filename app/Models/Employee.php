<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Model
{
    use HasFactory,HasApiTokens,Notifiable;

    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nik',
        'name',
        'gender',
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

    public function trainings()
    {
        return $this->hasMany(Training::class, 'nik', 'nik');
    }
}

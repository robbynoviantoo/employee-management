<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    // Menentukan tabel yang digunakan jika nama tabel tidak mengikuti konvensi plural
    protected $table = 'materis';

    // Menentukan kolom-kolom yang dapat diisi secara massal
    protected $fillable = [
        'materi_name',
        'kategori', // Menambahkan kategori ke dalam fillable
    ];

    // Mendefinisikan relasi satu ke banyak dengan model Training
    public function trainings()
    {
        return $this->hasMany(Training::class, 'materi_id');
    }
}

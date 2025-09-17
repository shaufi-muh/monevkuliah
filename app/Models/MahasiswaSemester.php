<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaSemester extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'semester_akademik_id',
        'status_mahasiswa',
    ];
}

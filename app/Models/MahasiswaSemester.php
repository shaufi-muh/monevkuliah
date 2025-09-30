<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaSemester extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'tahun_akademik_id',
        'status_mahasiswa',
    ];
}

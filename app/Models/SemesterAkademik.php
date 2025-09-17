<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemesterAkademik extends Model
{
    use HasFactory;
    protected $fillable = [
        'tahun_akademik',
        'semester',
        'status',
        'jurusan_id',
    ];
}

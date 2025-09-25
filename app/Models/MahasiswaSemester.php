<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaTahun extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tahun_akademik_id',
        'status_mahasiswa',
    ];
}

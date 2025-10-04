<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    use HasFactory;
    protected $fillable = [
        'pertanyaan_id',
        'dosen_id',
        'matakuliah_id',
        'real_pertemuan',
        'jawaban_boolean',
        'keterangan',
    ];
}

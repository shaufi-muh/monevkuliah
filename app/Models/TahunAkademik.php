<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAkademik extends Model
{
    use HasFactory;
    protected $fillable = [
        'tahun_akademik',
        'semester',
        'status',
        'jurusan_id',
    ];

    public function kuisioners()
    {
        return $this->hasMany(Kuisioner::class);
    }

    public function mahasiswaSemesters()
    {
        return $this->hasMany(MahasiswaSemester::class);
    }
}

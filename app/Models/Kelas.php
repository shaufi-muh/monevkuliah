<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $fillable = [
        'prodi_id',
        'urutan_semester',
        'grup_kelas',
        'nama_kelas'
    ];

    public function mahasiswas()
    {
        return $this->belongsToMany(Mahasiswa::class, 'kelas_mahasiswa');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
}

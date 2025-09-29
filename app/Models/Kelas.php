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
        return $this->belongsToMany(Mahasiswa::class, 'kelas_mahasiswa', 'kelas_id', 'mahasiswa_id');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    // Relasi many-to-many ke MataKuliah
    public function mataKuliahs()
    {
        return $this->belongsToMany(MataKuliah::class, 'kelas_mata_kuliah');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_matkul',
        'nama_matkul',
        'sks',
        'tahun',
    ];
    // Relasi many-to-many ke Kelas
    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_mata_kuliah');
    }
}

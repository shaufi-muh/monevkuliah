<?php

namespace App\Models;

// Mengimpor class-class yang dibutuhkan oleh Model.
use Illuminate\Database\Eloquent\Factories\HasFactory; // Trait untuk fitur factory (berguna untuk testing).
use Illuminate\Database\Eloquent\Model; // Class dasar untuk semua model di Laravel (Eloquent).

class Mahasiswa extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nim',
        'nama',
        'email',
        'no_telp',
    ];

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_mahasiswa');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
}

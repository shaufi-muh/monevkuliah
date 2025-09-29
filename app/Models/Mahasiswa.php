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
        'status',
    ];

    // Parameter:
    // 1. Model tujuan: Kelas::class
    // 2. Nama tabel pivot: 'kelas_mahasiswa'
    // 3. Foreign key model ini di tabel pivot: 'mahasiswa_id' (atau 'mahasiswa_id' sesuai desain Anda)
    // 4. Foreign key model tujuan di tabel pivot: 'kelas_id'
    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_mahasiswa', 'mahasiswa_id', 'kelas_id');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
}

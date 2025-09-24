<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuisioner extends Model
{
    use HasFactory;
    protected $fillable = [
        'tahun_akademik', // baru
        'semester',       // baru
        'sesi',           
        'diskripsi',
        'status',
        'jurusan_id', // Pastikan ini ada
    ];

    // Relasi: Satu Kuisioner dimiliki oleh satu Jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
     
    // Relasi: Satu Kuisioner memiliki banyak Pertanyaan
    public function pertanyaans()
    {
        return $this->hasMany(Pertanyaan::class);
    }

    // Relasi: Satu Kuisioner dimiliki oleh satu Tahun Akademik
    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }
}

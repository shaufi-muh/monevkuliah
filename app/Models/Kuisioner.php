<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuisioner extends Model
{
    use HasFactory;
    protected $fillable = [
        'tahun_akademik',
        'semester',
        'sesi',
        'deskripsi',
        'status',
        'jurusan_id',
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
}

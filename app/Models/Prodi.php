<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_prodi',
        'kode_prodi',
        'akronim_prodi',
        'jurusan_id',
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
    
    // Relasi: satu Prodi bisa punya satu user pengelola
    public function users()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Mendefinisikan relasi "one-to-many" ke model Dosen.
     * Sebuah Prodi memiliki banyak Dosen.
     */
    public function dosens()
    {
        return $this->hasMany(Dosen::class);
    }
}

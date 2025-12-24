<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_jurusan',
        'kode_jurusan',
        'akronim_jurusan',
        'kajur_id',
    ];

    // Relasi: satu Jurusan punya banyak Prodi
    public function prodi()
    {
        return $this->hasMany(Prodi::class);
    }

    public function ketua()
    {
        return $this->belongsTo(Dosen::class, 'kajur_id');
    }
}

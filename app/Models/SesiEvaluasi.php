<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiEvaluasi extends Model
{
    use HasFactory;
    protected $table = 'sesi_evaluasi';
    protected $fillable = [
        'mahasiswa_nim',
        'kuisioner_id',
        'tahun_akademik',
        'token_utama',
        'berlaku_hingga',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_nim', 'nim');
    }

    public function kuisioner()
    {
        return $this->belongsTo(Kuisioner::class);
    }
}

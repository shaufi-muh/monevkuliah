<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;
    protected $fillable = [
        'kuisioner_id', // <-- PASTIKAN INI ADA
        'isi_pertanyaan',
        'tipe_jawaban',
        'urutan',
    ];

    /**
     * Get the kuisioner that owns the pertanyaan.
     */
    public function kuisioner()
    {
        return $this->belongsTo(Kuisioner::class);
    }
}

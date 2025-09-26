<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluasiToken extends Model
{
    // app/Models/EvaluasiToken.php
    protected $fillable = [
        'user_id', 
        'kuisioner_id', 
        'token', 
        'digunakan_pada'];

    // Tambahkan relasi ini untuk kemudahan
    public function mahasiswa() { 
        return $this->belongsTo(Mahasiswa::class, 'user_id'); 
    }

    public function kuisioner() { 
        return $this->belongsTo(Kuisioner::class); 
    }
}

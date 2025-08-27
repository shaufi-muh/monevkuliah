<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;
    protected $fillable = [
        'nip',
        'nuptk',
        'nama_dosen',
        'homebase',
    ];
}

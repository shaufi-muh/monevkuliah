<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nip',
        'nuptk',
        'nama_dosen',
        //'homebase',
        'prodi_id',
    ];

    /**
     * Mendefinisikan relasi bahwa Dosen ini milik satu Prodi.
     */
    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
}

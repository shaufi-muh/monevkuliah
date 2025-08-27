<?php

namespace App\Models;

// Mengimpor class-class yang dibutuhkan oleh Model.
use Illuminate\Database\Eloquent\Factories\HasFactory; // Trait untuk fitur factory (berguna untuk testing).
use Illuminate\Database\Eloquent\Model; // Class dasar untuk semua model di Laravel (Eloquent).

class Mahasiswa extends Model
{
    use HasFactory;
       
    /**
     * (3) Mass Assignment Protection ($fillable)
     * Properti ini SANGAT PENTING untuk keamanan.
     * Ini adalah "daftar putih" kolom-kolom mana saja yang boleh diisi
     * secara massal menggunakan metode seperti `Mahasiswa::create([...])`.
     * Kolom 'id', 'created_at', dan 'updated_at' tidak perlu dimasukkan di sini.
     */
    protected $fillable = [
        'nim',
        'nama',
        'email',
        'no_telp',
    ];

    /**
     * (Opsional) Menentukan nama tabel secara eksplisit.
     * Laravel biasanya sudah pintar menebak nama tabel (mahasiswas),
     * tapi jika nama tabel Anda tidak sesuai standar, Anda bisa menentukannya di sini.
     *
     * protected $table = 'tabel_mahasiswa';
     */

    /**
     * (Opsional) Menentukan primary key jika bukan 'id'.
     * Jika Anda ingin 'nim' menjadi primary key, Anda bisa tambahkan ini.
     *
     * protected $primaryKey = 'nim';
     * public $incrementing = false;
     * protected $keyType = 'string';
     */
}

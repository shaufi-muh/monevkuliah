<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jurusan; // <-- Pastikan model Jurusan di-import

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Langsung membuat 1 data Jurusan tanpa factory
        Jurusan::create([
            'nama_jurusan' => 'Komputer dan Bisnis',
            'kode_jurusan' => 'Jur01',
            'akronim_jurusan' => 'Kombis', // <-- Tambahkan kolom lain jika ada dan dibutuhkan
            // Pastikan kolom 'nama_jurusan' ada di migrasi tabel jurusans Anda
        ]);
    }
}

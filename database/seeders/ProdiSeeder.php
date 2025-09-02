<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Prodi; // <-- Pastikan model PRodi di-import

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Langsung membuat 1 data Prodi tanpa factory
        PRodi::create([
            'nama_prodi' => 'Teknologi Rekayasa Komputer Jaringan',
            'kode_prodi' => 'Prodi01',
            'akronim_prodi' => 'TRKJ', // <-- Tambahkan kolom lain jika ada dan dibutuhkan
            // Pastikan kolom 'nama_prodi' ada di migrasi tabel prodis Anda
        ]);
    }
}

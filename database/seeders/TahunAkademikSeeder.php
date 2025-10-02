<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahunAkademik;

class TahunAkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            // Contoh data tahun akademik
            $tahunAkademik = TahunAkademik::create([
                'tahun_akademik' => '2025/2026',
                'semester' => 'Ganjil',
                'status' => 'aktif',
                'jurusan_id' => 1, // pastikan jurusan_id 1 sudah ada
            ]);
    }  
}

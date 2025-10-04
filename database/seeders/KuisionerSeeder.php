<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kuisioner;
use App\Models\Pertanyaan;

class KuisionerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            // Contoh data kuisioner
            $kuisioner = Kuisioner::create([
                'tahun_akademik' => '2025/2026',
                'semester' => 'Ganjil',
                'sesi' => 'Tengah',
                'deskripsi' => '',
                'status' => 'aktif',
                'jurusan_id' => 1, // pastikan jurusan_id 1 sudah ada
            ]);
    }  
}

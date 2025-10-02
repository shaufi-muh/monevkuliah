<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kuisioner;
use App\Models\Pertanyaan;

class PertanyaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil kuisioner pertama (atau sesuaikan dengan kebutuhan)
        $kuisioner = \App\Models\Kuisioner::first();
        if (!$kuisioner) return;

        $pertanyaanList = [
            [
                'isi_pertanyaan' => 'Realisasi Pertemuan?',
                'tipe_jawaban' => 'numerik',
                'urutan' => 1,
            ],
            [
                'isi_pertanyaan' => 'Apakah ada penyampaian RPS?',
                'tipe_jawaban' => 'boolean',
                'urutan' => 2,
            ],
            [
                'isi_pertanyaan' => 'Apakah soal memiliki kesesuaian dengan RPS?',
                'tipe_jawaban' => 'boolean',
                'urutan' => 3,
            ],
        ];

        foreach ($pertanyaanList as $data) {
            Pertanyaan::create([
                'kuisioner_id' => $kuisioner->id,
                'isi_pertanyaan' => $data['isi_pertanyaan'],
                'tipe_jawaban' => $data['tipe_jawaban'],
                'urutan' => $data['urutan'],
            ]);
        }
    }
}

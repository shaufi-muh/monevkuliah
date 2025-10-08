<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SesiEvaluasi;
use App\Models\Mahasiswa;
use App\Models\Kuisioner;

class SesiEvaluasiSeeder extends Seeder
{
    public function run()
    {
        // $kuisioner = Kuisioner::inRandomOrder()->first();
        // $tahunAkademik = $kuisioner ? $kuisioner->tahun_akademik : '2025/2026';

        // foreach (Mahasiswa::inRandomOrder()->limit(10)->get() as $mhs) {
        //     SesiEvaluasi::create([
        //         'mahasiswa_nim' => $mhs->nim,
        //         'kuisioner_id' => $kuisioner->id ?? 1,
        //         'tahun_akademik' => $tahunAkademik,
        //         'token_utama' => bin2hex(random_bytes(16)),
        //     ]);
        // }
    }
}
<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Prodi;

class ProdiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_prodi' => 'Teknologi Rekayasa Komputer Jaringan', 'jenjang_pendidikan' => 'D4', 'akronim_prodi' => 'TRKJ', 'jurusan_id' => 1],
            ['nama_prodi' => 'Teknologi Informasi', 'jenjang_pendidikan' => 'D3', 'akronim_prodi' => 'TI', 'jurusan_id' => 1],
            ['nama_prodi' => 'Agroindustri', 'jenjang_pendidikan' => 'D3', 'akronim_prodi' => 'AI', 'jurusan_id' => 2],
            ['nama_prodi' => 'Teknologi Pakan Ternak', 'jenjang_pendidikan' => 'D4', 'akronim_prodi' => 'TPT', 'jurusan_id' => 2],
            ['nama_prodi' => 'Teknologi Rekayasa Pemeliharaan Alat Berat', 'jenjang_pendidikan' => 'D4', 'akronim_prodi' => 'TRPAB', 'jurusan_id' => 3],
        ];
        foreach ($data as $item) {
            Prodi::create($item);
        }
    }
}

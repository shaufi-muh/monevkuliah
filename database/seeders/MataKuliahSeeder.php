<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\MataKuliah;

class MataKuliahSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode_matkul' => 'MK001', 'nama_matkul' => 'Matematika', 'sks' => '3', 'tahun' => 1],
            ['kode_matkul' => 'MK002', 'nama_matkul' => 'Fisika', 'sks' => '2', 'tahun' => 1],
            ['kode_matkul' => 'MK003', 'nama_matkul' => 'Kimia', 'sks' => '2', 'tahun' => 2],
            ['kode_matkul' => 'MK004', 'nama_matkul' => 'Pemrograman', 'sks' => '3', 'tahun' => 2],
            ['kode_matkul' => 'MK005', 'nama_matkul' => 'Jaringan', 'sks' => '2', 'tahun' => 3],
        ];
        foreach ($data as $item) {
            MataKuliah::create($item);
        }
    }
}

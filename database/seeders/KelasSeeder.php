<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['prodi_id' => 1, 'urutan_semester' => 1, 'grup_kelas' => 'A', 'nama_kelas' => 'TRKJ-1A'],
            ['prodi_id' => 2, 'urutan_semester' => 1, 'grup_kelas' => 'B', 'nama_kelas' => 'TI-1B'],
            ['prodi_id' => 3, 'urutan_semester' => 2, 'grup_kelas' => 'A', 'nama_kelas' => 'AI-2A'],
            ['prodi_id' => 4, 'urutan_semester' => 2, 'grup_kelas' => 'B', 'nama_kelas' => 'TPT-2B'],
            ['prodi_id' => 5, 'urutan_semester' => 3, 'grup_kelas' => 'A', 'nama_kelas' => 'TRPAB-3A'],
        ];
        foreach ($data as $item) {
            Kelas::create($item);
        }
    }
}

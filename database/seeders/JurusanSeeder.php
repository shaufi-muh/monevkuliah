<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_jurusan' => 'Komputer dan Bisnis', 'kode_jurusan' => 'Jur01', 'akronim_jurusan' => 'Kombis'],
            ['nama_jurusan' => 'Teknologi Industri Pertanian', 'kode_jurusan' => 'Jur02', 'akronim_jurusan' => 'TIP'],
            ['nama_jurusan' => 'Rekayasa dan Industri', 'kode_jurusan' => 'Jur03', 'akronim_jurusan' => 'RI'],
           
        ];
        foreach ($data as $item) {
            Jurusan::create($item);
        }
    }
}

<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['prodi_id' => 1, 'nim' => '21001', 'nama' => 'Mahasiswa A', 'email' => 'a@mhs.com', 'no_telp' => '0811111111'],
            ['prodi_id' => 2, 'nim' => '21002', 'nama' => 'Mahasiswa B', 'email' => 'b@mhs.com', 'no_telp' => '0812222222'],
            ['prodi_id' => 3, 'nim' => '21003', 'nama' => 'Mahasiswa C', 'email' => 'c@mhs.com', 'no_telp' => null],
            ['prodi_id' => 4, 'nim' => '21004', 'nama' => 'Mahasiswa D', 'email' => 'd@mhs.com', 'no_telp' => '0814444444'],
            ['prodi_id' => 5, 'nim' => '21005', 'nama' => 'Mahasiswa E', 'email' => 'e@mhs.com', 'no_telp' => null],
        ];
        foreach ($data as $item) {
            Mahasiswa::create($item);
        }
    }
}

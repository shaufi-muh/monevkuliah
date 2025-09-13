<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Dosen;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_dosen' => 'Dosen A', 'nip' => '19800101', 'nuptk' => '12345678', 'prodi_id' => 1],
            ['nama_dosen' => 'Dosen B', 'nip' => '19800202', 'nuptk' => '22345678', 'prodi_id' => 2],
            ['nama_dosen' => 'Dosen C', 'nip' => null, 'nuptk' => null, 'prodi_id' => 3],
            ['nama_dosen' => 'Dosen D', 'nip' => '19800404', 'nuptk' => null, 'prodi_id' => 4],
            ['nama_dosen' => 'Dosen E', 'nip' => null, 'nuptk' => '52345678', 'prodi_id' => 5],
        ];
        foreach ($data as $item) {
            Dosen::create($item);
        }
    }
}

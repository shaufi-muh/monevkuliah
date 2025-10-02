<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jurusan;
use App\Models\Prodi;
use App\Models\Dosen;
use App\Models\TahunAkademik;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Kelas;
use App\Models\Kuisioner;
use App\Models\Pertanyaan;
//use App\Models\Jawaban;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); */
            $this->call([
                
                JurusanSeeder::class,
                ProdiSeeder::class,
                DosenSeeder::class,
                TahunAkademikSeeder::class,
                MahasiswaSeeder::class,
                MataKuliahSeeder::class,
                KelasSeeder::class,
                KuisionerSeeder::class,
                PertanyaanSeeder::class,
                //JawabanSeeder::class,
                UserSeeder::class,
                
            ]);
    }
}

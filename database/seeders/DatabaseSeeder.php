<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jurusan;
use App\Models\Prodi;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Kelas;
//use App\Models\Kuisioner;
//use App\Models\Pertanyaan;
//use App\Models\Jawaban;

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
                UserSeeder::class,
                JurusanSeeder::class,
                ProdiSeeder::class,
                DosenSeeder::class,
                MahasiswaSeeder::class,
                MataKuliahSeeder::class,
                KelasSeeder::class,
                //KuisionerSeeder::class,
                //PertanyaanSeeder::class,
                //JawabanSeeder::class,
            ]);
    }
}

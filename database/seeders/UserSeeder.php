<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Prodi;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
     /*   // 1. Buat atau cari Jurusan, dan simpan hasilnya dalam variabel $jurusan
        $jurusan = Jurusan::firstOrCreate(
            ['nama_jurusan' => 'Komputer dan Bisnis'],
            ['kode_jurusan' => 'Jur01', 'akronim_jurusan' => 'Kombis']
        );                                                                          ******BUAT JUR DAN PROD DI SINI*******
        // 2. Buat atau cari Prodi, dan simpan hasilnya dalam variabel $prodi
        $prodi = Prodi::firstOrCreate(
            ['nama_prodi' => 'Teknologi Rekayasa Komputer Jaringan'],
            ['jenjang_pendidikan' => 'D4', 'akronim_prodi' => 'TRKJ', 'jurusan_id' => $jurusan->id,]
        ); */

        // 1. Ambil jurusan yang sudah ada (dari seeder), misal berdasarkan nama dan kode
        $jurusan = Jurusan::where('nama_jurusan', 'Komputer dan Bisnis')
            ->where('kode_jurusan', 'Jur01')
            ->first();
        // 2. Ambil prodi yang sudah ada (dari seeder), misal berdasarkan nama dan jenjang
        $prodi = Prodi::where('nama_prodi', 'Teknologi Rekayasa Komputer Jaringan')
            ->where('jenjang_pendidikan', 'D4')
            ->first();
        // 3. Buat user Jurusan, gunakan $jurusan->id yang PASTI ada
        User::firstOrCreate(
            ['email' => 'kombis@example.com'],
            [
                'name' => 'Jur Kombis',
                'password' => Hash::make('password'),
                'role' => 'jurusan',
                'jurusan_id' => $jurusan->id, // <-- Terhubung langsung, tidak mencari lagi
            ]
        );
        // 4. Buat user Prodi, gunakan $prodi->id yang PASTI ada
        User::firstOrCreate(
            ['email' => 'trkj@example.com'],
            [
                'name' => 'Prodi TRKJ',
                'password' => Hash::make('password'),
                'role' => 'prodi',
                'jurusan_id' => $jurusan->id,
                'prodi_id' => $prodi->id, // <-- Terhubung langsung, tidak mencari lagi
            ]
        );
    }
}

//kandang logika if
/*$jurusan = Jurusan::where('nama_jurusan', 'Komputer dan Bisnis')->first();
        $prodi = Prodi::where('nama_prodi', 'Teknologi Rekayasa Komputer Jaringan')->first();

        if ($jurusan) {
            User::create([
                'name' => 'Jur Kombis',
                'email' => 'kombis@example.com',
                'password' => Hash::make('password'),
                'role' => 'jurusan',
                'jurusan_id' => $jurusan->id, // <-- INI DIA KUNCINYA
            ]);
        } 
        
        if ($prodi) {
            User::create([
                'name' => 'Prodi TRKJ',
                'email' => 'trkj@example.com',
                'password' => Hash::make('password'),
                'role' => 'prodi',
                'prodi_id' => $prodi->id, // <-- INI DIA KUNCINYA
            ]);
        } */

/**
     * Run the database seeds.
     */
/*    // AKADEMIK
        User::create([
            'name' => 'Akademik role',
            'email' => 'akademik@example.com',
            'password' => Hash::make('password'),
            'role' => 'akademik',
        ]); */

        /*// JURUSAN tanpa jurusan_id
        User::create([
            'name' => 'Op Kombis',
            'email' => 'kombis@example.com',
            'password' => Hash::make('password'),
            'role' => 'jurusan',
        ]);*/

        // === BAGIAN YANG DIMODIFIKASI ===

        // 1. Cari dulu Jurusan yang akan dihubungkan.
        // Pastikan Jurusan dan Prodi sudah dibuat oleh JurusanSeeder dan ProdiSeeder

        
        // 2. Hapus user lama agar tidak ada duplikat saat seeder dijalankan ulang.
        //User::where('email', 'kombis@example.com')->delete();
        //User::where('email', 'trkj@example.com')->delete();

        // 3. Buat user baru, kali ini LENGKAP dengan jurusan_id.
        // Pastikan $jurusan ditemukan sebelum membuat user.
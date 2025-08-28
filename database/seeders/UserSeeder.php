<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    /*    // AKADEMIK
        User::create([
            'name' => 'Akademik role',
            'email' => 'akademik@example.com',
            'password' => Hash::make('password'),
            'role' => 'akademik',
        ]); */

        // JURUSAN
        User::create([
            'name' => 'Op Kombis',
            'email' => 'kombis@example.com',
            'password' => Hash::make('password'),
            'role' => 'jurusan',
        ]);
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan foreign key untuk Jurusan
            $table->foreignId('jurusan_id')->nullable()->constrained()->after('role');

            // Menambahkan foreign key untuk Prodi
            $table->foreignId('prodi_id')->nullable()->constrained()->after('jurusan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus constraint sebelum menghapus kolom
            $table->dropForeign(['jurusan_id']);
            $table->dropForeign(['prodi_id']);
            
            $table->dropColumn(['jurusan_id', 'prodi_id']);
        });
    }
};

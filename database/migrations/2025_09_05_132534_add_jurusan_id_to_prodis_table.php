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
        Schema::table('prodis', function (Blueprint $table) {
            // Menambahkan kolom foreign key 'jurusan_id'
            // `nullable()` berarti kolom ini boleh kosong (untuk user seperti akademik)
            // `after('id')` agar posisinya rapi (opsional)
            $table->foreignId('jurusan_id')->nullable()->constrained()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prodis', function (Blueprint $table) {
            // Hapus constraint sebelum menghapus kolom
            $table->dropForeign(['jurusan_id']);
            $table->dropColumn(['jurusan_id']);
        });
    }
};

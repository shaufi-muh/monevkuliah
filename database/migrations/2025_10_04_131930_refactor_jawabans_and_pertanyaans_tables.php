<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Memperbarui tabel pertanyaans untuk tipe jawaban yang lebih beragam
        DB::statement("ALTER TABLE pertanyaans CHANGE COLUMN tipe_jawaban tipe_jawaban ENUM('numerik', 'boolean', 'text', 'tanggal') NOT NULL");

        // 2. Memperbarui tabel jawabans
        Schema::table('jawabans', function (Blueprint $table) {
            // Menambahkan kolom baru untuk jawaban numerik yang lebih sesuai
            $table->integer('jawaban_numerik')->nullable()->after('jawaban_boolean');
            
            // Mengganti nama 'keterangan' menjadi 'jawaban_text' untuk kejelasan
            $table->renameColumn('keterangan', 'jawaban_text');

            // Menambahkan kolom baru untuk tipe jawaban tanggal di masa depan
            $table->date('jawaban_tanggal')->nullable()->after('jawaban_text');

            // Menghapus kolom 'real_pertemuan' yang tidak lagi diperlukan
            $table->dropColumn('real_pertemuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Mengembalikan perubahan pada tabel jawabans
        Schema::table('jawabans', function (Blueprint $table) {
            $table->integer('real_pertemuan');
            $table->dropColumn('jawaban_tanggal');
            $table->renameColumn('jawaban_text', 'keterangan');
            $table->dropColumn('jawaban_numerik');
        });

        // 2. Mengembalikan perubahan pada tabel pertanyaans
        DB::statement("ALTER TABLE pertanyaans CHANGE COLUMN tipe_jawaban tipe_jawaban ENUM('numerik', 'boolean') NOT NULL");
    }
};
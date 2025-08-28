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
        Schema::create('jawabans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pertanyaan_id')->constrained('pertanyaans');
            $table->foreignId('dosen_id')->constrained('dosens');
            $table->foreignId('matakuliah_id')->constrained('mata_kuliahs');

            $table->integer('real_pertemuan');
            // Menggunakan tipe data boolean untuk jawaban ya/tidak.
            // Di database ini akan menjadi TINYINT(1).
            $table->boolean('jawaban_boolean');

            // Kolom deskripsi tetap ada untuk pertanyaan esai
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawabans');
    }
};

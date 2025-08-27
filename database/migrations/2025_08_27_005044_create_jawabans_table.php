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

            // Isi jawaban
            $table->enum('jawaban_pilihan', ['sesuai', 'tidak_sesuai'])->nullable();
            $table->text('jawaban_deskripsi')->nullable();

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

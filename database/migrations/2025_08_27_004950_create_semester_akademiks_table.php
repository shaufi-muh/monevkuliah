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
        Schema::create('semester_akademiks', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_akademik'); // Contoh: "2025/2026"
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('tidak_aktif');
            $table->foreignId('jurusan_id')->constrained('jurusans');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semester_akademiks');
    }
};

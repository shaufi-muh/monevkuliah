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
        Schema::create('kuisioners', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_akademik'); // Menyimpan tahun, contoh: 2025
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->enum('sesi', ['Tengah', 'Akhir']); //Contoh: "Evaluasi Tengah Semester Ganjil 2025"
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('tidak_aktif');

            // Menghubungkan setiap kuisioner ke jurusan yang membuatnya
            $table->foreignId('jurusan_id')->constrained('jurusans');
            
            $table->timestamps();
        });
    }
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuisioners');
    }
};

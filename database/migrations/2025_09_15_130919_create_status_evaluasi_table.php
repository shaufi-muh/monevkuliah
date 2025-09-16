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
        Schema::create('status_evaluasi', function (Blueprint $table) {
        $table->id();

        // Identitas unik untuk setiap mahasiswa di setiap kelas/matkul
        $table->string('mahasiswa_nim');
        $table->foreign('mahasiswa_nim')->references('nim')->on('mahasiswas');
        $table->foreignId('matakuliah_id')->constrained('mata_kuliahs');

        // "Tiket" unik yang akan dikirim ke mahasiswa
        // $table->string('token')->unique();
        // gak jadi dipakai karena token_utama di sesi_evaluasi sudah cukup

        // Status untuk melacak proses
        $table->enum('status', ['belum_mengisi', 'sudah_mengisi'])->default('belum_mengisi');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_evaluasi');
    }
};

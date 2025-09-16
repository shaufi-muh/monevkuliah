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
        Schema::create('sesi_evaluasi', function (Blueprint $table) {
            $table->id();
            $table->string('mahasiswa_nim');
            $table->foreign('mahasiswa_nim')->references('nim')->on('mahasiswas');

            // "Tiket Masuk Utama" yang akan dikirim via WA/SMS
            $table->string('token_utama')->unique();

            // Opsional: Batas waktu token berlaku
            $table->timestamp('berlaku_hingga')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi_evaluasi');
    }
};

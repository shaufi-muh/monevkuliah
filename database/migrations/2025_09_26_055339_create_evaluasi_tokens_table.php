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
        Schema::create('evaluasi_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->onDelete('cascade'); // Mahasiswa yang dituju
            $table->foreignId('kuisioner_id')->constrained('kuisioners')->onDelete('cascade'); // Kuisioner yang digunakan
            $table->string('token', 100)->unique(); // Token unik
            $table->timestamp('digunakan_pada')->nullable(); // Menandai kapan token digunakan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluasi_tokens');
    }
};

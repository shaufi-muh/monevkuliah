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
        Schema::create('mahasiswa_semesters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->onDelete('cascade');
            $table->foreignId('tahun_akademik_id')->constrained('tahun_akademiks')->onDelete('cascade');
            $table->enum('status_mahasiswa', ['Aktif', 'Cuti', 'Non-Aktif'])->default('Non-Aktif');
            $table->timestamps();

            // Kunci: Mencegah duplikasi data. Satu mahasiswa hanya bisa punya satu status per tahun.
            $table->unique(['mahasiswa_id', 'tahun_akademik_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa_semesters');
    }
};

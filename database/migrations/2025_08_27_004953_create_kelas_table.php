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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_akademik_id')
              ->nullable() // Dibuat nullable agar tidak error jika sudah ada data
              ->constrained('tahun_akademiks');
            $table->foreignId('prodi_id')->constrained('prodis');
            $table->integer('urutan_semester');
            $table->char('grup_kelas', 1);
            $table->string('nama_kelas')->unique(); // cth: TRKJ-1A
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};

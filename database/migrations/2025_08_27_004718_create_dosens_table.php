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
        Schema::create('dosens', function (Blueprint $table) {
            $table->id();

            $table->string('nip')->nullable();
            $table->string('nuptk')->nullable();
            $table->string('nama_dosen');
            //$table->string('homebase')->nullable();
            $table->foreignId('prodi_id')->constrained('prodis'); // <-- Ganti dengan ini
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosens');
    }
};

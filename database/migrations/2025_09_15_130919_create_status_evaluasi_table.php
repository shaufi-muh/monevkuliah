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

            // Foreign key yang merujuk langsung ke sesi evaluasi yang dibuat
            $table->foreignId('sesi_evaluasi_id')->constrained('sesi_evaluasi')->onDelete('cascade');

            // Status untuk melacak proses, 'selesai' sudah cukup
            $table->string('status')->default('selesai');

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

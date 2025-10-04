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
        Schema::table('kelas_mahasiswa', function (Blueprint $table) {
            $table->foreignId('tahun_akademik_id')->nullable()->after('mahasiswa_id')->constrained('tahun_akademiks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas_mahasiswa', function (Blueprint $table) {
            $table->dropForeign(['tahun_akademik_id']);
            $table->dropColumn('tahun_akademik_id');
        });
    }
};

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('kelas_mata_kuliah', function (Blueprint $table) {
            $table->foreignId('tahun_akademik_id')->nullable()->after('mata_kuliah_id')->constrained('tahun_akademiks')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('kelas_mata_kuliah', function (Blueprint $table) {
            $table->dropForeign(['tahun_akademik_id']);
            $table->dropColumn('tahun_akademik_id');
        });
    }
};

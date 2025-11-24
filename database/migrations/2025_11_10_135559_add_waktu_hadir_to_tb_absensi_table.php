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
        Schema::table('tb_absensi', function (Blueprint $table) {
            $table->timestamp('waktu_hadir')->nullable()->after('ttd');
            $table->index('waktu_hadir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_absensi', function (Blueprint $table) {
            $table->dropIndex(['waktu_hadir']);
            $table->dropColumn('waktu_hadir');
        });
    }
};

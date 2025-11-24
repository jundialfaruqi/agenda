<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tb_agenda', function (Blueprint $table) {
            if (!Schema::hasColumn('tb_agenda', 'status')) {
                $table->enum('status', ['aktif', 'selesai', 'dibatalkan'])->default('aktif')->after('catatan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_agenda', function (Blueprint $table) {
            if (Schema::hasColumn('tb_agenda', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
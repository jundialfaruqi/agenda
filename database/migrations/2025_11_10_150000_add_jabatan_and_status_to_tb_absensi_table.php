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
        Schema::table('tb_absensi', function (Blueprint $table) {
            // Tambahkan kolom jabatan (nullable)
            if (!Schema::hasColumn('tb_absensi', 'jabatan')) {
                $table->string('jabatan')->nullable()->after('name');
            }

            // Tambahkan kolom status (enum: hadir/tidak_hadir) default 'hadir'
            if (!Schema::hasColumn('tb_absensi', 'status')) {
                $table->enum('status', ['hadir', 'tidak_hadir'])->default('hadir')->after('waktu_hadir');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_absensi', function (Blueprint $table) {
            if (Schema::hasColumn('tb_absensi', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('tb_absensi', 'jabatan')) {
                $table->dropColumn('jabatan');
            }
        });
    }
};
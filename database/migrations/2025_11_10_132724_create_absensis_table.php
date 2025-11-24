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
        Schema::create('tb_absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agenda_id')->constrained('tb_agenda');
            $table->foreignId('opd_id')->nullable()->constrained('tb_opd');
            $table->string('nip_nik');
            $table->string('name');
            $table->enum('asal_daerah', ['dalam_kota', 'luar_kota']);
            $table->string('telp');
            $table->string('instansi')->nullable();
            $table->string('ttd')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('agenda_id');
            $table->index('opd_id');
            $table->index('nip_nik');
            $table->index('asal_daerah');
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_absensi');
    }
};

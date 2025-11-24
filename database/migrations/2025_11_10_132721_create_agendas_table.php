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
        Schema::create('tb_agenda', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opd_id')->constrained('tb_opd');
            $table->foreignId('user_id')->constrained('users');
            $table->string('name');
            $table->string('slug')->unique();
            $table->date('date');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('link_paparan')->nullable();
            $table->string('link_zoom')->nullable();
            $table->string('barcode')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('opd_id');
            $table->index('user_id');
            $table->index('date');
            $table->index('slug');
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_agenda');
    }
};

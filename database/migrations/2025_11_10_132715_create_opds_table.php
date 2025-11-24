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
        Schema::create('tb_opd', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('singkatan');
            $table->text('alamat');
            $table->string('telp');
            $table->string('logo')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('name');
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_opd');
    }
};

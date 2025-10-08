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
        Schema::create('periode_layanan', function (Blueprint $table) {
            $table->id('id_periode');
            $table->string('nama_periode');
            $table->text('deskripsi')->nullable();
            $table->foreignId('id_user')->constrained('admin','id_user')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periode_layanan');
    }
};
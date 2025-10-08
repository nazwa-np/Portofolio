<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ruang_kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ruang');
            $table->string('jenis_kelas');
            $table->integer('kapasitas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ruang_kelas');
    }
};

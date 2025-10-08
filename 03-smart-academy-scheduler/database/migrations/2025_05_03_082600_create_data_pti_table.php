<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('data_pti', function (Blueprint $table) {
            $table->string('kode_mk');
            $table->string('matkul');
            $table->string('dosen');
            $table->integer('semester');
            $table->integer('sks_teori');
            $table->integer('sks_praktek');
            $table->integer('sks_lapangan');
            $table->integer('total_sks');
            $table->string('group');
            $table->string('lokal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_pti');
    }
};

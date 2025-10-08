<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('save_data_ti', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mk');
            $table->string('matkul');
            $table->string('dosen');
            $table->string('semester');
            $table->integer('sks_teori');
            $table->integer('sks_praktek');
            $table->integer('sks_lapangan');
            $table->integer('total_sks');
            $table->string('group');
            $table->string('lokal');
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('save_data_ti');
    }
};

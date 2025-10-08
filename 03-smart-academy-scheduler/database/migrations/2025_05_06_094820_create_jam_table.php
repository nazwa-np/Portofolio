<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jam', function (Blueprint $table) {
            $table->id();
            $table->integer('jam_ke');     // Kolom untuk nomor jam ke-
            $table->string('waktu');       // Kolom untuk rentang waktu, misalnya "07:00 - 08:00"
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jam');
    }
};

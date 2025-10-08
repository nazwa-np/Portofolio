<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefJabatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_jabatan', function (Blueprint $table) {
            $table->id('id_jabatan'); // Primary key
            $table->string('nm_jabatan', 100); // Nama Jabatan
            $table->integer('kum'); // KUM (angka kredit jabatan)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_jabatan');
    }
}

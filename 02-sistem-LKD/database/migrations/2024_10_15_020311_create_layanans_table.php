<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayanansTable extends Migration
{
    public function up()
    {
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            $table->string('nidn');
            $table->string('nama');
            $table->string('nomor_sertifikat')->nullable();
            $table->string('status');
            $table->string('kode_pt');
            $table->string('nama_pt');
            $table->string('kode_prodi');
            $table->string('nama_prodi');
            $table->string('jabatan_fungsional');
            $table->string('golongan_pangkat');
            $table->string('upload_file');
            $table->enum('verifikasi', ['pending', 'approved', 'rejected'])->default('pending'); // Kolom verifikasi dengan enum
            $table->timestamps(); // Menambahkan kolom created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('layanans');
    }
}

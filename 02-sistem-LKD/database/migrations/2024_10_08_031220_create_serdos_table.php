<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSerdosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serdos', function (Blueprint $table) {
            $table->id('id_serdos'); // Primary Key
            $table->string('nidn', 20); // NIDN Dosen
            $table->string('no_sertifikat', 50); // Nomor Sertifikat
            $table->year('tahun'); // Tahun Sertifikasi
            $table->unsignedBigInteger('id_gol2'); // ID Golongan
            $table->date('tmt_pangkat')->nullable(); // TMT Pangkat
            $table->string('file_serdos', 255)->nullable(); // File Sertifikasi (path file)
            $table->date('tgl_inpt'); // Tanggal Input
            $table->timestamp('last_update')->useCurrent(); // Last Update
            $table->string('status_serdos', 50); // Status Sertifikasi
            $table->text('ket_serdos')->nullable(); // Keterangan Sertifikasi
            $table->boolean('soft_delete')->default(false); // Soft Delete (untuk penghapusan logis)
            $table->timestamp('verified_at')->nullable(); // Waktu Verifikasi
            $table->unsignedBigInteger('idpwi')->nullable(); // ID PWI (Pengawas Wilayah)
            $table->string('jns_dok_serdos', 50)->nullable(); // Jenis Dokumen Sertifikasi
            $table->text('komen_serdos')->nullable(); // Komentar Sertifikasi
            $table->string('no_registrasi', 50)->nullable(); // Nomor Registrasi
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('serdos');
    }
}

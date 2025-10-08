<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen', function (Blueprint $table) {
            $table->string('npsn', 50);
            $table->string('nama_pt', 255);
            $table->string('nm_sdm', 255);
            $table->string('jk', 1);
            $table->string('tmpt_lahir', 255);
            $table->date('tgl_lahir');
            $table->string('nm_ibu_kandung', 255);
            $table->string('stat_kawin', 20);
            $table->string('nik', 20);
            $table->string('nip', 20);
            $table->string('nidn', 20)->unique();
            $table->date('tmt_pns');
            $table->string('sk_cpns', 255);
            $table->date('tgl_sk_cpns');
            $table->string('sk_angkat', 255);
            $table->date('tmt_sk_angkat');
            $table->string('npwp', 20);
            $table->unsignedBigInteger('id_stat_aktif');
            $table->string('prodi', 255);
            $table->string('kode_prodi', 50);
            $table->string('no_serdos', 50);
            $table->string('no_rek', 50);
            $table->string('stat_serdos', 20);
            $table->string('id_ikatan_kerja', 20);
            $table->integer('id_gol');
            $table->date('tmt_gol');
            $table->integer('thn_gol');
            $table->integer('bln_gol');
            $table->integer('id_jabatan');
            $table->date('tmt_jabatan');
            $table->integer('thn_jabatan');
            $table->integer('bln_jabatan');
            $table->integer('kum_terakhir');
            $table->integer('id_didik');
            $table->date('tmt_didik');
            $table->string('gelar_depan', 50);
            $table->string('gelar_belakang', 50);
            $table->string('fakultas', 255);
            $table->string('ft_dsn', 50);
            $table->string('password', 255);
            $table->integer('id_gol_pns');
            $table->date('tmt_gol_pns');
            $table->integer('thn_gol_pns');
            $table->integer('kel_wilayah');
            $table->integer('id_sms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dosen');
    }
}

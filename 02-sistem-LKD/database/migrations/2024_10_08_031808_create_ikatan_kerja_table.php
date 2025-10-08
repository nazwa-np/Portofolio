<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIkatanKerjaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ikatan_kerja', function (Blueprint $table) {
            $table->id();
            $table->string('id_ikatan_kerja', 10); // Primary Key dengan tipe string
            $table->string('nm_ikatan_kerja', 100); // Nama Ikatan Kerja
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ikatan_kerja');
    }
}

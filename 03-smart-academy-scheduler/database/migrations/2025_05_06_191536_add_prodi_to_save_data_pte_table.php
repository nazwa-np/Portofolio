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
        Schema::table('save_data_pte', function (Blueprint $table) {
            $table->string('prodi')->nullable();
        });
    }

    public function down()
    {
        Schema::table('save_data_pte', function (Blueprint $table) {
            $table->dropColumn('prodi');
        });
    }

};

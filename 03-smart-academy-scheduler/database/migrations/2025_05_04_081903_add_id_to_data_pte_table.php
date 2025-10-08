<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdToDataPteTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('data_pte', function (Blueprint $table) {
            // Jika kolom id belum ada, tambahkan sebagai primary key dan auto increment
            $table->bigIncrements('id')->first();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_pte', function (Blueprint $table) {
            $table->dropColumn('id');
        });
    }
}

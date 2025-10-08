<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PtsImport; // Buat class import ini

class PtsSeeder extends Seeder
{
    public function run()
    {
        Excel::import(new PtsImport, storage_path('app/public/Daftar.csv'));

    }
}

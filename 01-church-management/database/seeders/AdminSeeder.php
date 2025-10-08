<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admin')->insert([
            'nama_user' => 'admin',
            'password' => Hash::make('admin123'),
            'foto' => null,
        ]);
    }
}

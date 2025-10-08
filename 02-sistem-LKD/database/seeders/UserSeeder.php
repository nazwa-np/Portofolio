<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // Tambahkan untuk query DB

class UserSeeder extends Seeder
{
    public function run()
    {
        // Cek dan buat akun SuperAdmin jika belum ada
        User::firstOrCreate([
            'username' => 'superadmin', // Username untuk SuperAdmin
        ], [
            'password' => Hash::make('1234567890'), // Hash password
            'role' => 'superadmin', // Role sebagai SuperAdmin
        ]);

        // Cek dan buat akun Admin jika belum ada
        User::firstOrCreate([
            'username' => 'admin', // Username untuk Admin
        ], [
            'password' => Hash::make('0987654321'), // Hash password
            'role' => 'admin', // Role sebagai Admin
        ]);

        // Ambil NIDN dari tabel dosen
        $dosenList = DB::table('dosen')->select('nidn')->get();

        // Loop setiap dosen dan buat akun di tabel users jika belum ada
        foreach ($dosenList as $dosen) {
            User::firstOrCreate([
                'username' => $dosen->nidn,  // Cek berdasarkan NIDN
            ], [
                'password' => Hash::make($dosen->nidn),  // Password juga menggunakan NIDN
                'role' => 'dosen',    // Role sebagai dosen
            ]);
        }
    }
}

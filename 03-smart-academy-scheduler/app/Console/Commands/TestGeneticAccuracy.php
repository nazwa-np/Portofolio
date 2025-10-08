<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GeneticScheduler;
use Illuminate\Support\Facades\DB;

class TestGeneticAccuracy extends Command
{
    protected $signature = 'genetic:test';
    protected $description = 'Menjalankan algoritma genetika dan menampilkan hasil pengujian';

    public function handle()
    {
        $this->info("Menjalankan algoritma genetika...");


        $pdo = DB::connection()->getPdo();
        $scheduler = new GeneticScheduler(DB::connection(), $pdo);

        $hasil = $scheduler->runGeneticAlgorithm();

        $this->info("Contoh hasil jadwal:");
        foreach (array_slice($hasil, 0, 5) as $jadwal) {
            $this->line("{$jadwal['course']['matkul']} - {$jadwal['course']['dosen']} - {$jadwal['room']} - {$jadwal['time']['hari']} jam ke-{$jadwal['time']['jam_ke']}");
        }

        $this->info("=== Pengujian selesai ===");
    }


}

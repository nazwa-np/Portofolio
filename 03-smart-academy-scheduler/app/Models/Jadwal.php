<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    public $timestamps = false;

    protected $fillable = [
        'kode_seksi','kode_mk', 'matkul', 'dosen', 'hari', 'jam_ke', 'waktu', 'lokal', 
        'sks_teori', 'sks_praktek', 'sks_lapangan', 'total_sks','group', 'semester','prodi', 'perkuliahan'
    ];

}

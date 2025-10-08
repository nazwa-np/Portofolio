<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'jadwal';
    public $timestamps = false;

    protected $fillable = [
        'kode_mk',
        'matkul',
        'semester',
        'dosen',
        'hari',
        'jam',
        'lokal',
        'sks_teori',
        'sks_praktek',
        'sks_lapangan',
        'total_sks',
        'group'
    ];


}

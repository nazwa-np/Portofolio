<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstraintsRuang extends Model
{
    use HasFactory;

    protected $table = 'constraints_ruang';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'kode_seksi',
        'kode_mk',
        'matkul',
        'prodi',
        'jenis_kelas',
        'lokal',
        'perkuliahan',
        'kapasitas'
    ];

}

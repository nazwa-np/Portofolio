<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_pti extends Model
{
    use HasFactory;

    protected $table = 'data_pti';

    public $timestamps = false;

    protected $fillable = [
        'kode_seksi','kode_mk', 'matkul', 'dosen', 'semester',
        'sks_teori', 'sks_praktek', 'sks_lapangan', 'total_sks','group', 'perkuliahan'
    ];

}

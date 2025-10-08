<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaveDataTI extends Model
{
    protected $table = 'save_data_ti'; 

    public $timestamps = false; 
    protected $fillable = [
        'kode_seksi',
        'kode_mk',
        'matkul',
        'dosen',
        'semester',
        'sks_teori',
        'sks_praktek',
        'sks_lapangan',
        'total_sks',
        'group',
        'perkuliahan',
        'prodi'
    ];
}

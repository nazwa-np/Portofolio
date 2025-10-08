<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaveDataPTE extends Model
{
    protected $table = 'save_data_pte'; // atau sesuaikan dengan nama tabelmu

    public $timestamps = false; // ⬅️ tambahkan ini untuk menonaktifkan created_at dan updated_at

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

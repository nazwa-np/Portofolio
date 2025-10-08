<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    public $timestamps = false;
    protected $fillable = [
        'id',
        'kode_seksi',
        'kode_mk',
        'prodi',
        'group',
        'jml_mhs'
    ];


}

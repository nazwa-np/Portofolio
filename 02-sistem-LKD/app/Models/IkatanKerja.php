<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IkatanKerja extends Model
{
    use HasFactory;

    protected $table = 'ikatan_kerja';
    protected $primaryKey = 'id_ikatan_kerja';
    protected $fillable = [
        'nm_ikatan_kerja',
        'ket_ikatan_kerja'
    ];

    public function dosens()
    {
        return $this->hasMany(Dosen::class, 'id_ikatan_kerja');
    }
}

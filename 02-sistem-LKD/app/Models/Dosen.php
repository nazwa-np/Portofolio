<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';
    // Tentukan kolom mana yang merupakan primary key
    protected $primaryKey = 'nidn'; // Gunakan kolom 'nidn' sebagai kunci utama

    // Jika kunci utama bukan integer, set properti ini
    public $incrementing = false; // Kunci utama tidak menggunakan incrementing

    // Jika kunci utama bukan integer, set jenis kunci ini
    protected $keyType = 'string'; // Sesuaikan dengan tipe data 'nidn'

    public $timestamps = false;
    
     // Tentukan atribut yang bisa diisi
     protected $fillable = [
        'nidn', 
        'nm_sdm', 
        'id_ikatan_kerja', 
        'npsn', 
        'nama_pt', 
        'kode_prodi', 
        'prodi', 
        'id_jabatan', 
        'id_gol'
    ];


    public function ikatanKerja()
    {
        return $this->belongsTo(IkatanKerja::class, 'id_ikatan_kerja');
    }

    public function refJabatan()
    {
        return $this->belongsTo(RefJabatan::class, 'id_jabatan');
    }

    public function serdos()
    {
        return $this->hasOne(Serdos::class, 'nidn', 'nidn');
    }

    public function pangkatGol()
    {
        return $this->belongsTo(PangkatGol::class, 'id_gol');
    }

    
}
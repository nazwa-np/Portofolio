<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jam extends Model
{
    use HasFactory;

    protected $table = 'jam';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'jam_ke',
        'waktu'
    ];


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstraintsDosen extends Model
{
    use HasFactory;

    protected $table = 'constraints_dosen';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'dosen',
        'hari',
        'jam_ke',
        'status'
    ];

}

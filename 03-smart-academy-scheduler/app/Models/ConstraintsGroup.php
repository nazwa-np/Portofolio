<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstraintsGroup extends Model
{
    use HasFactory;

    protected $table = 'constraints_group';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'group',
        'semester',
        'prodi',
        'jml_mhs'
    ];

}

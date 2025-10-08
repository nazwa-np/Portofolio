<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    // Define the table if it's not the plural of the model name
    protected $table = 'layanans';

    // Specify the fillable fields if needed
    protected $fillable = ['NIDN', 'NAMA', /* other fields */];
}

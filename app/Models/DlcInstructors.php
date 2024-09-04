<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DlcInstructors extends Model
{
    use HasFactory;
    protected $table = 'dlc_instructors';
    protected $fillable = [
        'instructor_id', 
        'firstname',
        'middlename',
        'lastname',
        'sex', 
        'department',
    ];
}

// need edit dlc instructor table and department searching feature

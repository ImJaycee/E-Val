<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorArchives extends Model
{
    use HasFactory;
    protected $table = 'dlc_instructors_archives';
    protected $fillable = [
        'instructor_id',
        'firstname',
        'middlename',
        'lastname',
        'email',
        'sex',
        'department',
        'pfp'
    ];
}

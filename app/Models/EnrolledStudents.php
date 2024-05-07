<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrolledStudents extends Model
{
    use HasFactory;
    protected $table = 'enrolled_students';
    protected $fillable = [
        'student_id', //student_id
        'student_name', //student_
    ];
}

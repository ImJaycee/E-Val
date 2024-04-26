<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectEnrolled extends Model
{
    use HasFactory;
    protected $table = 'subject_enrolled';
    protected $fillable = [
        'student_id', //student_id
        'subject_code',
        'section',
    ];
}

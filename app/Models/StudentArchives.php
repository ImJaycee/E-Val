<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentArchives extends Model
{
    use HasFactory;
    protected $table = 'dlc_students_archives';
    protected $fillable = [
        'student_id',
        'email',
        'eval_token',
        'subject1',
        'subject2',
        'subject3',
        'subject4',
        'subject5',
        'subject6',
        'subject7',
        'subject8',
        'subject9',
        'subject10',
        'A_Y',
        'semester'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentEvaluation extends Model
{
    use HasFactory;
    protected $table = 'student_evaluation';
    protected $fillable = [
        'instructor_id',
        'eval_token',
        'subject_code',
        //'section',
        'semester',
        'A_Y',
        'I-1',
        'I-2',
        'I-3',
        'II-1',
        'II-2',
        'II-3',
        'II-4',
        'III-1',
        'III-2',
        'IV-1',
        'IV-2',
        'V-1',
        'V-2',
        'V-3',
        'comments',
        'sentiment',
        'I_Total',
        'II_Total',
        'III_Total',
        'IV_Total',
        'V_Total',
        'total_score'
    ];
}

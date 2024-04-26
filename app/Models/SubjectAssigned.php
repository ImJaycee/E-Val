<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectAssigned extends Model
{
    use HasFactory;
    protected $table = 'subject_assigned';
    protected $fillable = [
        'instructor_id',
        'instructor_name',
        'subject_code',
        'section',
    ];
}

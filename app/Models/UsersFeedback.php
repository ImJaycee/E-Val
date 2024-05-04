<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersFeedback extends Model
{
    use HasFactory;
    protected $table = 'users-feedback';
    protected $fillable = [
        'users_id', //student_id
        'rating',
        'comment',
    ];
}

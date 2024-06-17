<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class StudentsTokenAccounts extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'student_id',
        'email',
        'eval_token',
        'subjet1',
        'subjet2',
        'subjet3',
        'subjet4',
        'subjet5',
        'subjet6',
        'subjet7',
        'subjet8',
        'subjet9',
        'subjet10',
    ];
  

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class StudentAccount extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'student_id',
        'contact',
        'firstname',
        'middlename',
        'lastname',
        'email',
        'program',
        'year',
        'section',
        'pfp', //profile picture
        'password',
    ];
}

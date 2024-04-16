<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class InstructorAccount extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'instructor_id',
        'contact',
        'firstname',
        'middlename',
        'lastname',
        'email',
        'department',
        'pfp', //profile picture
        'password',
        'password_reset_token',
    ];
}

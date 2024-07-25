<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminAccount extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'admin_account'; 
    protected $fillable = [
        'admin_id',
        'firstname',
        'middlename',
        'lastname',
        'email',
        'password',
    ];
}

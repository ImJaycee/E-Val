<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeerToPeer extends Model
{
    use HasFactory;
    protected $table = 'peer_assignment';
    protected $fillable = ['instructor_id', 'peer1', 'peer2', 'peer3', 'peer4', 'peer5', 'status'];
}

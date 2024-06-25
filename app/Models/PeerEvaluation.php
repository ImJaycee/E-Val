<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeerEvaluation extends Model
{
    use HasFactory;
    protected $table = 'peer_evaluation';
    protected $fillable = [
        'instructor_id',
        'evaluator_id',
        'a_1',
        'a_2',
        'a_3',
        'a_4',
        'a_5',
        'a_6',
        'b_1',
        'b_2',
        'b_3',
        'b_4',
        'b_5',
        'b_6',
        'c_1',
        'c_2',
        'c_3',
        'c_4',
        'c_5',
        'c_6',
        'comments',
        'sentiment',
        'semester',
        'A_Y',
        'A_Total',
        'B_Total',
        'C_Total',
        'overall_total'
    ];
}

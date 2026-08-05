<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'ticket_id',
        'result_date',
        'super_position_1',
        'super_position_2',
        'super_position_3',
        'super_position_4',
        'super_position_5',
        'super_encouragement_prize',
        'box_position_1',
        'box_position_2',
        'box_position_3',
        'box_position_4',
        'box_position_5',
        'box_position_6',
        'ab',
        'bc',
        'ac',
        'a',
        'b',
        'c'
    ];
}

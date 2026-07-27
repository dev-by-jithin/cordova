<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected function casts(): array
    {
        return [
            'result_time' => 'datetime:H:i:s',
        ];
    }
}

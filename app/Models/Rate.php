<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function mode()
    {
        return $this->belongsTo(Mode::class);
    }
}

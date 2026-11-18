<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Limit extends Model
{
    public function mode()
    {
        return $this->belongsTo(Mode::class);
    }
}

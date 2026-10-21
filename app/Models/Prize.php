<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    public function mode()
    {
        return $this->belongsTo(Mode::class);
    }
}

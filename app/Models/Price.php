<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    public function scheme()
    {
        return $this->belongsTo(Scheme::class);
    }

    public function mode()
    {
        return $this->belongsTo(Mode::class);
    }
}

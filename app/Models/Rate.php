<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = ['user_rate'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function mode()
    {
        return $this->belongsTo(Mode::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

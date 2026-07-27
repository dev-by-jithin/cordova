<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Number extends Model
{
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function mode()
    {
        return $this->belongsTo(Mode::class);
    }

    public function superAgent()
    {
        return $this->belongsTo(User::class, 'super_agent_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}

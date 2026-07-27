<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'bill_id',
        'super_agent_id',
        'agent_id',
        'ticket_id',
        'remarks'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}

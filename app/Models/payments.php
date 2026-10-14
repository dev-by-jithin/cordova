<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class payments extends Model
{
    protected $fillable = [
        'from_date',
        'to_date',
        'sale',
        'winning',
        'commission',
        'net',
        'super_agent_id'
    ];

    public function superAgent()
    {
        return $this->belongsTo(User::class, 'super_agent_id');
    }
}

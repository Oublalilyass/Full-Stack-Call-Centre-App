<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['agent_id', 'supervisor_id','subject', 'details', 'status'];
    
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }
}


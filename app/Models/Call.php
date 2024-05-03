<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    protected $fillable = ['agent_id','call_datetime','duration','subject'];

    public function agent()
    {
         return $this->belongsTo(Agent::class);
    }
}

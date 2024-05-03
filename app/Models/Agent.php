<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = ['name','email'];

    public function calls()
    {
         return $this->hasMany(Call::class);
    }
    
    public function tickets()
    {
         return $this->hasMany(Ticket::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    
    protected $fillable = ['name', 'email'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}

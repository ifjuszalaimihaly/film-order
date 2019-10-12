<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

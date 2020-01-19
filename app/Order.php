<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function film()
    {
        return $this->belongsTo(Film::class);
    }

    public function status()
    {
        return $this->hasOneThrough(
            Status::class,
            Film::class,
            "first_key",
            "second_key",
            "local_key",
            "second_local_key"
        );
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Torrent extends Model
{
    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}

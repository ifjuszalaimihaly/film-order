<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class)->withDefault();
    }

    public function torrent()
    {
        return $this->hasOne(Torrent::class);
    }
}

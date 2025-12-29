<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = [];

    public function equipments()
    {
        return $this->belongsToMany(Equipment::class, 'room_equipment');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\RoomStatusService;

class Booking extends Model
{
    protected $fillable = [
        'room_id',
        'user_id',
        'title',
        'organizer',
        'attendees',
        'start_time',
        'end_time',
        'status',
        'note',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time'   => 'datetime',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::deleted(function ($booking) {
            app(\App\Services\RoomStatusService::class)
                ->refresh($booking->room_id);
        });
    }
}

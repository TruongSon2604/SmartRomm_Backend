<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use App\Models\Room;
use App\Services\RoomStatusService;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RefreshRoomStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
   public function handle(RoomStatusService $roomStatusService): void
    {
        dump('Job is running');
        Log::info('RefreshRoomStatusJob started');

        Room::all()->each(function ($room) {
            app(RoomStatusService::class)->refresh($room->id);
            Log::info('Room refreshed', ['room_id' => $room->id]);
        });

        Log::info('RefreshRoomStatusJob finished');
    }
}

<?php

namespace App\Services;

use App\Repositories\BookingRepository;
use App\Repositories\RoomRepository;

class RoomStatusService
{
    public function __construct(
        protected BookingRepository $bookingRepo,
        protected RoomRepository $roomRepo
    ) {}


    public function refresh(int $roomId): void
    {
        $hasActive = $this->bookingRepo->hasActiveBooking($roomId);

        $this->roomRepo->updateStatus(
            $roomId,
            $hasActive ? 'busy' : 'available'
        );
    }
}
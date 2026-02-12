<?php
namespace App\Repositories\Contracts;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Collection;
interface BookingRepositoryInterface 
{
    public function all(): Collection;

    public function findById(int $id): ?Booking;

    public function create(array $data): Booking;

    public function update(Booking $booking, array $data): Booking;

    public function delete(Booking $booking): bool;

    public function hasConflict(
        int $roomId,
        Carbon $start,
        Carbon $end,
        ?int $ignoreBookingId = null
    ): bool;
}
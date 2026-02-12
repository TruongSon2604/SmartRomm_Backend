<?php
namespace App\Repositories;

use App\Models\Booking;
use App\Repositories\Contracts\BookingRepositoryInterface;
use Carbon\Carbon;

class BookingRepository implements BookingRepositoryInterface
{
    public function all(): \Illuminate\Support\Collection
    {
        return Booking::with(['room', 'user'])->orderBy('start_time')->get();
    }

    public function findById(int $id): ?Booking
    {
        return Booking::find($id);
    }
    
    public function create(array $data): Booking
    {
        return Booking::create($data);
    }

    public function update(Booking $booking, array $data): Booking
    {
        $booking->update($data);
        return $booking;
    }

    public function delete(Booking $booking): bool
    {
        return $booking->delete();
    }

    public function hasConflict(
        int $roomId,
        Carbon $start,
        Carbon $end,
        ?int $ignoreBookingId = null
    ): bool {
        $query = Booking::where('room_id', $roomId)
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_time', [$start, $end])
                  ->orWhereBetween('end_time', [$start, $end])
                  ->orWhere(function ($q2) use ($start, $end) {
                      $q2->where('start_time', '<=', $start)
                         ->where('end_time', '>=', $end);
                  });
            });

        if ($ignoreBookingId) {
            $query->where('id', '!=', $ignoreBookingId);
        }

        return $query->exists();
    }

    public function hasActiveBooking(int $roomId): bool
    {
        $now = Carbon::now();

        return Booking::where('room_id', $roomId)
            ->where('start_time', '<=', $now)
            ->where('end_time', '>=', $now)
            ->exists();
    }
}

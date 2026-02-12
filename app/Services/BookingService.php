<?php 
namespace App\Services;

use App\Repositories\BookingRepository;
use App\Repositories\RoomRepository;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class BookingService
{
    public function __construct(
        protected BookingRepository $bookingRepo,
        protected RoomRepository $roomRepo
    ) {}

    /**
     * Create a new booking
     */
    public function create(array $data)
    {
        $start = Carbon::parse($data['start_time']);
        $end   = Carbon::parse($data['end_time']);

        if ($start >= $end) {
            throw ValidationException::withMessages([
                'time' => 'End time must be after start time'
            ]);
        }

        Log::info('Creating booking 1');
        // Check conflict
        if ($this->bookingRepo->hasConflict(
            $data['room_id'],
            $start,
            $end
        )) {
            // return throw ValidationException::withMessages([
            //     'conflict' => 'Booking time conflicts with an existing booking'
            // ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Booking time conflicts with an existing booking',
                'errors' => [
                    'conflict' => ['Booking time conflicts with an existing booking']
                ]
            ], 422);
        }

        // create booking
        $booking = $this->bookingRepo->create($data);

        // if the booking is for current time, update room status to busy
        if ( $start <= now() && $end >= now()) {
            $this->roomRepo->updateStatus(
                $data['room_id'],
                'busy'
            );
        }

        return $booking;
    }

    public function getAll()
    {
        return $this-> bookingRepo->all();  
    }

    public function update(int $id, array $data)
    {
        $booking = $this->bookingRepo->findById($id);

        if (!$booking) {
            throw new Exception('Booking không tồn tại');
        }

        $start = Carbon::parse($data['start_time']);
        $end   = Carbon::parse($data['end_time']);

        if ($this->bookingRepo->hasConflict(
            $booking->room_id,
            $start,
            $end,
            $booking->id
        )) {
            throw new Exception('Trùng lịch đặt phòng');
        }

        return $this->bookingRepo->update($booking, $data);
    }

    public function delete(int $id)
    {
        $booking = $this->bookingRepo->findById($id);

        if (!$booking) {
            throw new Exception('Booking không tồn tại');
        }

        return $this->bookingRepo->delete($booking);
    }
}
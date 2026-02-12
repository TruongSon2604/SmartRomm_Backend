<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BookingService;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index()
    {
        return response()->json(
            $this->bookingService->getAll()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id'    => 'required|exists:rooms,id',
            'title'      => 'required|string',
            'organizer'  => 'required|string',
            'attendees'  => 'required|integer|min:1',
            'start_time' => 'required|date',
            'end_time'   => 'required|date|after:start_time',
            'note'       => 'nullable|string',
        ]);

        $data['user_id'] = auth()->id();

        return $this->bookingService->create($data);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'title'      => 'required|string',
            'organizer'  => 'required|string',
            'attendees'  => 'required|integer|min:1',
            'start_time' => 'required|date',
            'end_time'   => 'required|date|after:start_time',
            'status'     => 'in:pending,approved,rejected,canceled',
            'note'       => 'nullable|string',
        ]);

        return response()->json(
            $this->bookingService->update($id, $data)
        );
    }

    public function destroy(int $id)
    {
        $this->bookingService->cancel($id);

        return response()->json([
            'message' => 'Đã hủy booking'
        ]);
    }
}
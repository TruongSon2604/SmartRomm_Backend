<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RoomService;

class RoomController extends Controller
{
    protected $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'capacity' => 'required|integer',
            'location' => 'required',
            'description' => 'nullable|string',
            'status' => 'required',
        ]);

        return $this->roomService->createRoom($data);
    }

    public function index()
    {
        return $this->roomService->getAllRooms();
    }

    public function show($id)
    {
        return $this->roomService->getRoomById($id);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|required',
            'capacity' => 'sometimes|required|integer',
            'location' => 'sometimes|required',
            'description' => 'nullable|string',
            'status' => 'sometimes|required',
        ]);

        return $this->roomService->updateRoom($id, $data);
    }

    public function destroy($id)
    {
        $deleted = $this->roomService->deleteRoom($id);
        if ($deleted) {
            return response()->json(['message' => 'Room deleted successfully'], 200);
        }
        return response()->json(['message' => 'Room not found'], 404);
    }
}

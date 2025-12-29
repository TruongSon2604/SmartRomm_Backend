<?php

namespace App\Services;

use App\Repositories\Contracts\RoomRepositoryInterface;

class RoomService
{
    protected $roomRepository;

    public function __construct(RoomRepositoryInterface $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    public function getAllRooms()
    {
        return $this->roomRepository->all();
    }

    public function createRoom(array $data)
    {
        return $this->roomRepository->create($data);
    }

    public function getRoomById(int $id)
    {
        return $this->roomRepository->find($id);
    }

    public function updateRoom(int $id, array $data)
    {
        $room = $this->roomRepository->find($id);
        if ($room) {
            $this->roomRepository->update($room, $data);
            return $room;
        }
        return null;
    }

    public function deleteRoom(int $id)
    {
        $room = $this->roomRepository->find($id);
        if ($room) {
            return $this->roomRepository->delete($room);
        }
        return false;
    }
}

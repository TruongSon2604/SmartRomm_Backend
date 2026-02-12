<?php
namespace App\Repositories;

use App\Models\Room;
use App\Repositories\Contracts\RoomRepositoryInterface;

class RoomRepository implements RoomRepositoryInterface
{
    public function all()
    {
        return Room::with('equipments')->get();
    }

    public function find(int $id): ?Room
    {
        return Room::find($id);
    }

    public function create(array $data): Room
    {
        return Room::create($data);
    }

    public function update(Room $room, array $data): bool
    {
        return $room->update($data);
    }

    public function delete(Room $room): bool
    {
        return $room->delete();
    }

    public function updateStatus(int $roomId, string $status): void
    {
        Room::where('id', $roomId)->update([
            'status' => $status
        ]);
    }

}
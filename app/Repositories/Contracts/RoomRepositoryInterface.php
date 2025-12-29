<?php 
namespace App\Repositories\Contracts;
use App\Models\Room;

interface RoomRepositoryInterface 
{
    public function all();
    public function find(int $id): ?Room;
    public function create(array $data): Room;
    public function update(Room $room, array $data): bool;
    public function delete(Room $room): bool;
}
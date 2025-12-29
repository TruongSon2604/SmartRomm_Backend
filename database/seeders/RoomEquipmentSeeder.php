<?php
namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomEquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $equipments = [
        ['name' => 'Projector'],
        ['name' => 'Whiteboard'],
        ['name' => 'Video Conference System'],
        ['name' => 'Microphone'],
    ];
    
    foreach ($equipments as $item) {
        Equipment::create($item);
    }

    // 2. Tạo Phòng họp bằng lệnh create() để lấy biến Object trả về
    $room1 = Room::create([
        'name' => 'Phòng họp 1',
        'capacity' => 10,
        'location' => 'Trục 24',
        'status' => 'available',
        'description' => 'Phòng họp trung',
    ]);

    $room2 = Room::create([
        'name' => 'Phòng họp 2',
        'capacity' => 20,
        'location' => 'Trục 6',
        'status' => 'available',
        'description' => 'Phòng họp trung',
    ]);

    $room3 = Room::create([
        'name' => 'Phòng họp 3',
        'capacity' => 30,
        'location' => 'Trục 5',
        'status' => 'available',
        'description' => 'Phòng họp lớn',
    ]);

    $room1->equipments()->attach([1, 2, 3, 4]); 
    $room2->equipments()->attach([1, 2, 3, 4]);
    $room3->equipments()->attach([1, 2, 3, 4]);
    }
}

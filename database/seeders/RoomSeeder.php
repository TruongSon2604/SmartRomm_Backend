<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rooms')->insert([
            [
                'name' => 'Phòng họp 1',
                'capacity' => 10,
                'location' => 'Trục 24',
                'status' => 'available',
                'description' => 'Phòng họp trung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Phòng họp 2',
                'capacity' => 20,
                'location' => 'Trục 6',
                'status' => 'available',
                'description' => 'Phòng họp trung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Phòng họp 3',
                'capacity' => 30,
                'location' => 'Trục 5',
                'status' => 'available',
                'description' => 'Phòng họp lớn',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

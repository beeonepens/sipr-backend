<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ruangan_json = file_get_contents('database\data\ruang.json');
        $ruangan = json_decode($ruangan_json, false);
        foreach ($ruangan as $value) {
            Room::create(
                [
                    'name_room' => $value->RUANG,
                    'description' => $value->KETERANGAN,
                    'isOnline' => 0,
                    'isBooked' => 0,
                    'user_id' => 1,
                ],
            );
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room')->insert([
            'name_room' => 'F01A',
            'description' => Str::random(50),
            'isOnline' => 0,
            'isBooked' => 0,
            'user_id' => 1,


        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'nip' => '1',
                'name' => 'Admin',
                'role_id' => 1,
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin4321'),
                'isActive' => true
            ],
            [
                'nip' => '3120500046',
                'name' => 'fahrimuda',
                'role_id' => 2,
                'email' => 'fahrimuda1@gmail.com',
                'password' => Hash::make('fahrimuda123'),
                'isActive' => true
            ],
            [
                'nip' => '3120500042',
                'name' => 'mahmud',
                'role_id' => 2,
                'email' => 'mahmud1@gmail.com',
                'password' => Hash::make('mahmud123'),
                'isActive' => true
            ],
            [
                'nip' => '3120500033',
                'name' => 'andi',
                'role_id' => 2,
                'email' => 'andi1@gmail.com',
                'password' => Hash::make('andi123'),
                'isActive' => true
            ],
        ]);
    }
}

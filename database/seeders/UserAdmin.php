<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nip' => '1',
            'name' => 'Admin',
            'role' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin4321'),
            'isActive' => true,
        ]);
    }
}

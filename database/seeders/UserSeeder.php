<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run () : void
    {
        User::factory ()->create ( [ 
            'name'     => 'Admin User',
            'email'    => 'admin@gmail.com',
            'role'     => 'admin',
            'password' => Hash::make ( '123456' ),
        ] );

        User::factory ()->create ( [ 
            'name'     => 'Regular User',
            'email'    => 'user@gmail.com',
            'role'     => 'user',
            'password' => Hash::make ( '123456' ),
        ] );
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'first_name' => 'Robinson',
                'last_name' => 'Isaiah',
                'role' => 'Admin',
                'email' => 'robinsonisaiah017@gmail.com',
                'latitude' => 40.712776,
                'longitude' => -74.005974,
                'date_of_birth' => '2000-10-25',
                'password' => Hash::make('password'),
                'timezone' => 'UTC',
                'remember_token' => Null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
            ]);
    }
}

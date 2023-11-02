<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::truncate();

        \App\Models\User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' =>bcrypt('password'),
            'phone' => '+4078 123 321',
            'address' => 'Romania, Str. Laravel Nr. 10',
            'role' => 'admin'
        ]);

        \App\Models\User::factory(25)->create();
    }
}

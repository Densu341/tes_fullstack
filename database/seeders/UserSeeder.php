<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Deni Irawan',
                'email' => 'deni@mail.com',
                'password' => bcrypt('password'),
            ],
        ]);
    }
}

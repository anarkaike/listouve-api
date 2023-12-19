<?php

namespace Database\Seeders\Users;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AddUserAnarkaikeSeeder extends Seeder
{
    public function run(): void
    {
        $usersData = [
            [
                'name' => 'Junio',
                'email' => 'anarkaike@gmail.com',
                'password' => bcrypt('123456'),
            ],
        ];
        DB::table('users')->insert($usersData);
    }
}

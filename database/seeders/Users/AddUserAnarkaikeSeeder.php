<?php

namespace Database\Seeders\Users;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeder para gerar usuários com dados aleatorios
 */
class AddUserAnarkaikeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
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

<?php

namespace Database\Seeders\Users;

use Illuminate\Database\Seeder;
use App\Models\User;

/**
 * Seeder para gerar usuários com dados aleatorios
 */
class UsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory(10)->create();
    }
}

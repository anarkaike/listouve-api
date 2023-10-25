<?php

namespace Database\Seeders;

use Database\Seeders\Events\EventsListsSeeder;
use Database\Seeders\Events\EventsSeeder;
use Database\Seeders\EventsListsItems\EventsListsItemsSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\Users\UsersSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(class: UsersSeeder::class);
        $this->call(class: EventsSeeder::class);
    }
}

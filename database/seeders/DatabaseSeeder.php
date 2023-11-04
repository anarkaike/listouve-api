<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\{Events\EventsListsSeeder,
    Events\EventsSeeder,
    EventsListsItems\EventsListsItemsSeeder,
    Users\AddUserAnarkaikeSeeder,
    Users\UsersSeeder};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(class: AddUserAnarkaikeSeeder::class);
//        $this->call(class: UsersSeeder::class);
//        $this->call(class: EventsSeeder::class);
//        $this->call(class: EventsListsSeeder::class);
//        $this->call(class: EventsListsItemsSeeder::class);
    }
}

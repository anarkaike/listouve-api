<?php

namespace Database\Seeders\EventsListsItems;

use Illuminate\Database\Seeder;
use App\Models\EventList;

class EventsListsItemsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         EventList::factory(count: 10)->create();
    }
}

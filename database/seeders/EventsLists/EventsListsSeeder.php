<?php

namespace Database\Seeders\Events;

use Illuminate\Database\Seeder;
use App\Models\EventList;

class EventsListsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         EventList::factory(count: 10)->create();
    }
}

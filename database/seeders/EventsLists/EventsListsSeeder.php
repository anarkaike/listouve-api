<?php

namespace Database\Seeders\EventsLists;

use Illuminate\Database\Seeder;
use App\Models\EventList;


class EventsListsSeeder extends Seeder
{
    public function run(): void
    {
         EventList::factory(count: 10)->create();
    }
}

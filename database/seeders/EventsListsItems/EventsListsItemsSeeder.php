<?php

namespace Database\Seeders\EventsListsItems;

use Illuminate\Database\Seeder;
use App\Models\EventList;

class EventsListsItemsSeeder extends Seeder
{
    public function run(): void
    {
         EventList::factory(count: 10)->create();
    }
}

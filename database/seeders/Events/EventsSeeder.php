<?php

namespace Database\Seeders\Events;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $a = Event::factory(count: 10)->create();
    }
}

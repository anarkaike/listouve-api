<?php

namespace Database\Seeders\Events;

use Illuminate\Database\Seeder;
use App\Models\Event;


class EventsSeeder extends Seeder
{
    public function run(): void
    {
         Event::factory(count: 10)->create();
    }
}

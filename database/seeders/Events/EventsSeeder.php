<?php

namespace Database\Seeders\Events;

use Illuminate\Database\Seeder;
use App\Models\Event;

/**
 * Seeder para gerar eventos com dados aleatorios
 */
class EventsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         Event::factory(count: 10)->create();
    }
}

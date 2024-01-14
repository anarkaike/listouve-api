<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\SaasClient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;


class EventListFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(maxNbChars: 500),
            'url_photo' => fake()->imageUrl(),
            'event_id' => Event::factory()->create()->id,
            'saas_client_id' => 0,
        ];
    }
}

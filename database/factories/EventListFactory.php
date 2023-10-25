<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventList>
 */
class EventListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => EventFactory::new()->create()->id,
            'name' => fake()->name(),
            'url_phone' => fake()->imageUrl(),
            'description' => fake()->text(maxNbChars: 500),
            'created_by' => Auth::id(),
        ];
    }
}

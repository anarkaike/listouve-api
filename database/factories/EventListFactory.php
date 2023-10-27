<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

/**
 * Classe para gerar listas de eventos com dados fake
 *
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
            'description' => fake()->text(maxNbChars: 500),
            'url_photo' => fake()->imageUrl(),
            'created_by' => Auth::id(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\SaasClient;
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
            'name' => fake()->name(),
            'description' => fake()->text(maxNbChars: 500),
            'url_photo' => fake()->imageUrl(),
            'event_id' => Event::factory()->create()->id,
            'saas_client_id' => SaasClient::factory()->create()->id,
        ];
    }
}

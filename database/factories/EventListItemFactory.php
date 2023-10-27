<?php

namespace Database\Factories;

use App\Enums\EventListItem\EventListItemPaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

/**
 * Classe para gerar items/nomes na lista de evento com dados fake
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventListItem>
 */
class EventListItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $eventList = EventListFactory::new()->create();

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '00000000000',
            'event_id' => $eventList->event_id,
            'event_list_id' => $eventList->id,
            'payment_status' => EventListItemPaymentStatusEnum::PENDING->value,
            'created_by' => Auth::id(),
        ];
    }
}

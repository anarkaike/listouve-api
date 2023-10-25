<?php

namespace Database\Factories;

use App\Enums\EventListItem\EventListItemPaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
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
            'event_id' => $eventList->event_id,
            'event_list_id' => $eventList->id,
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '00000000000',
            'payment_status' => EventListItemPaymentStatusEnum::PENDING,
            'created_by' => Auth::id(),
        ];
    }
}

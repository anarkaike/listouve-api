<?php

namespace Database\Factories;

use App\Enums\EventListItem\EventListItemPaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;


class EventListItemFactory extends Factory
{
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

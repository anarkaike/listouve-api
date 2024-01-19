<?php

namespace Database\Factories;

use App\Enums\EventListItem\EventListItemPaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;


class EventListItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '00000000000',
            'payment_status' => EventListItemPaymentStatusEnum::PENDING->value,
            'created_by' => Auth::id(),
        ];
    }
}

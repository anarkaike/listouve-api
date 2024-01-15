<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;


class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Festa do ' . fake()->name(),
            'starts_at' => $a = fake()->dateTimeThisMonth(),
            'ends_at' => fake()->dateTimeBetween($a, fake()->dateTimeBetween($a, '+30 days')),
            'duration_in_hours' => fake()->randomNumber(3),
            'url_banner' => fake()->imageUrl(),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'state' => fake()->streetAddress(),
            'contact_info' => fake()->phoneNumber(),
            'attractions_info' => fake()->name(),
            'payment_info' => fake()->text(),
            'restrictions_info' => fake()->text(),
            'ticket_info' => fake()->text(),
//            'social_networks' => [
//                ['url' => fake()->url(), 'type' => 'instagram'],
//                ['url' => fake()->url(), 'type' => 'facebook',]
//            ],
            'description' => fake()->text(500),
            'created_by' => Auth::id(),
        ];
    }
}

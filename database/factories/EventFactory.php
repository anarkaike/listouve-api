<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;


class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(500),
            'url_photo' => fake()->imageUrl(),
            'created_by' => Auth::id(),
        ];
    }
}

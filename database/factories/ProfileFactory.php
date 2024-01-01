<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class ProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'created_by' => 0,
        ];
    }
}

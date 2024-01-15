<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class ProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'created_by' => 0,
        ];
    }
}

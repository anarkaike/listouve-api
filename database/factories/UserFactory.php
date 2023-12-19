<?php

namespace Database\Factories;

use App\Enums\User\UserStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => fake()->password(),
            'remember_token' => Str::random(length:  10),
            'phone_personal' => fake()->phoneNumber(),
            'phone_professional' => fake()->phoneNumber(),
            'url_photo' => fake()->imageUrl(),
            'status' => UserStatusEnum::ACTIVE->value,
            'created_by' => 0,
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

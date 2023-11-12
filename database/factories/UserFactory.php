<?php

namespace Database\Factories;

use App\Enums\User\UserStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Classe para gerar um usuário com dados fake
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
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

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

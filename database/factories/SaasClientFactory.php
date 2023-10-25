<?php

namespace Database\Factories;

use App\Enums\SaasClient\SaasClientEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventList>
 */
class SaasClientFactory extends Factory
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
            'email_personal' => fake()->unique()->safeEmail(),
            'email_pofessional' => fake()->unique()->safeEmail(),
            'phone_personal' => '00000000000',
            'phone_pofessional' => '00000000000',
            'observation' => fake()->text(),
            'status' => SaasClientEnum::ACTIVE,
            'created_by' => Auth::id(),
        ];
    }
}

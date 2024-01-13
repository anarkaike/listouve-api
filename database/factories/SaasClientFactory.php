<?php

namespace Database\Factories;

use App\Enums\SaasClient\SaasClientBusinessSectorEnum;
use App\Enums\SaasClient\SaasClientStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;


class SaasClientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'company_name' => fake()->name(),
            'contact_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '00000000000',
            'observation' => fake()->text(),
            'status' => SaasClientStatusEnum::ACTIVE->value,
            'business_sector' => SaasClientBusinessSectorEnum::OUTROS->value,
            'created_by' => Auth::id(),
        ];
    }
}

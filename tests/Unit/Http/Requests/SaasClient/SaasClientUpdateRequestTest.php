<?php

namespace Tests\Unit\Http\Requests\SaasClient;

use App\Enums\SaasClient\SaasClientStatusEnum;
use App\Http\Requests\SaasClient\SaasClientUpdateRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use PHPUnit\Framework\TestCase;

class SaasClientUpdateRequestTest extends TestCase
{
    /**
     * Verifica a integridade das regras d validação do request
     *
     * @test
     */
    public function check_if_rules_is_correct(): void
    {
        $expectedValue = [
            'name' => ['nullable', 'string', 'max:255',],
            'email_personal' => ['nullable', 'string', 'email',],
            'email_professional' => ['nullable', 'string', 'email',],
            'phone_personal' => ['nullable', 'string', 'max:20',],
            'phone_professional' => ['nullable', 'string', 'max:20',],
            'observation' => ['nullable', 'string',],
            'status' => ['nullable', new Enum(SaasClientStatusEnum::class)],
        ];
        $actualValue = (new SaasClientUpdateRequest)->rules();

        $this->assertEquals(expected: $expectedValue, actual: $actualValue, message: 'As regras de validação do request está diferente. Atualize o teste.');
    }
}

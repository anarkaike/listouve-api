<?php

namespace Tests\Unit\Http\Requests\User;

use App\Enums\User\UserStatusEnum;
use App\Http\Requests\User\UserUpdateRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use PHPUnit\Framework\TestCase;

class UserUpdateRequestTest extends TestCase
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
            'email' => [
                'nullable',
                'string',
                'email',
                Rule::unique(table: 'users', column: 'email')
                    ->ignore(null, 'id')
                    ->whereNull('deleted_at'),
            ],
            'password' => ['nullable', 'string', 'max:255',],
            'phone_personal' => ['nullable', 'string', 'max:255',],
            'phone_professional' => ['nullable', 'string', 'max:255',],
            'url_photo' => ['nullable', 'string', 'max:255',],
            'status' => ['nullable', new Enum(UserStatusEnum::class)],
        ];
        $actualValue = (new UserUpdateRequest)->rules();

        $this->assertEquals(expected: $expectedValue, actual: $actualValue, message: 'As regras de validação do request está diferente. Atualize o teste.');
    }
}

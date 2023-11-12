<?php

namespace Tests\Unit\Enums;

use App\Enums\User\UserStatusEnum;
use PHPUnit\Framework\TestCase;

class UserStatusEnumTest extends TestCase
{
    /**
     * Verifica o retorno de getValues do enum UserStatusEnum
     * @test
     */
    public function check_if_user_status_enum_is_correct(): void
    {
        $expectedValue = ['active', 'blocked',];
        $actualValue = UserStatusEnum::getValues();

        $this->assertEquals(expected: $expectedValue, actual: $actualValue, message: 'Os valores do enum UserStatusEnum está incorreto.');
    }

    /**
     * Verifica valor/nome a valor/nome do enum
     * @test
     */
    public function check_if_vars_of_user_status_enum_is_correct(): void
    {
        $this->assertEquals(expected: 'active', actual: UserStatusEnum::ACTIVE->value, message: 'Valor do active dentro do enum está incorreto.');
        $this->assertEquals(expected: 'ACTIVE', actual: UserStatusEnum::ACTIVE->name, message: 'Nome do active dentro do enum está incorreto.');
        $this->assertEquals(expected: 'blocked', actual: UserStatusEnum::BLOCKED->value, message: 'Valor do blocked dentro do enum está incorreto.');
        $this->assertEquals(expected: 'BLOCKED', actual: UserStatusEnum::BLOCKED->name, message: 'Nome do blocked dentro do enum está incorreto.');
    }
}

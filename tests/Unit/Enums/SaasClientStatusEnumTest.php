<?php

namespace Tests\Unit\Enums;

use App\Enums\SaasClient\SaasClientStatusEnum;
use PHPUnit\Framework\TestCase;

class SaasClientStatusEnumTest extends TestCase
{
    /**
     * Verifica o retorno de getValues do enum SaasClientStatusEnum
     * @test
     */
    public function check_if_saas_client_status_enum_is_correct(): void
    {
        $expectedValue = ['active', 'active_testing', 'active_pending_payment', 'blocked', 'blocked_pending_payment', 'archived',];
        $actualValue = SaasClientStatusEnum::getValues();

        $this->assertEquals(expected: $expectedValue, actual: $actualValue, message: 'Os valores do enum SaasClientStatusEnum está incorreto.');
    }

    /**
     * Verifica valor/nome a valor/nome do enum
     * @test
     */
    public function check_if_vars_of_saas_client_status_enum_is_correct(): void
    {
        $this->assertEquals(expected: 'active', actual: SaasClientStatusEnum::ACTIVE->value, message: 'Valor do ACTIVE dentro do enum está incorreto.');
        $this->assertEquals(expected: 'active_testing', actual: SaasClientStatusEnum::ACTIVE_TESTING->value, message: 'Valor do ACTIVE_TESTING dentro do enum está incorreto.');
        $this->assertEquals(expected: 'active_pending_payment', actual: SaasClientStatusEnum::ACTIVE_PENDING_PAYMENT->value, message: 'Valor do ACTIVE_PENDING_PAYMENT dentro do enum está incorreto.');
        $this->assertEquals(expected: 'blocked', actual: SaasClientStatusEnum::BLOCKED->value, message: 'Valor do BLOCKED dentro do enum está incorreto.');
        $this->assertEquals(expected: 'blocked_pending_payment', actual: SaasClientStatusEnum::BLOCKED_PENDING_PAYMENT->value, message: 'Valor do BLOCKED_PENDING_PAYMENT dentro do enum está incorreto.');
        $this->assertEquals(expected: 'archived', actual: SaasClientStatusEnum::ARCHIVED->value, message: 'Valor do ARCHIVED dentro do enum está incorreto.');

        $this->assertEquals(expected: 'ACTIVE', actual: SaasClientStatusEnum::ACTIVE->name, message: 'Valor do ACTIVE dentro do enum está incorreto.');
        $this->assertEquals(expected: 'ACTIVE_TESTING', actual: SaasClientStatusEnum::ACTIVE_TESTING->name, message: 'Valor do ACTIVE_TESTING dentro do enum está incorreto.');
        $this->assertEquals(expected: 'ACTIVE_PENDING_PAYMENT', actual: SaasClientStatusEnum::ACTIVE_PENDING_PAYMENT->name, message: 'Valor do ACTIVE_PENDING_PAYMENT dentro do enum está incorreto.');
        $this->assertEquals(expected: 'BLOCKED', actual: SaasClientStatusEnum::BLOCKED->name, message: 'Valor do BLOCKED dentro do enum está incorreto.');
        $this->assertEquals(expected: 'BLOCKED_PENDING_PAYMENT', actual: SaasClientStatusEnum::BLOCKED_PENDING_PAYMENT->name, message: 'Valor do BLOCKED_PENDING_PAYMENT dentro do enum está incorreto.');
        $this->assertEquals(expected: 'ARCHIVED', actual: SaasClientStatusEnum::ARCHIVED->name, message: 'Valor do ARCHIVED dentro do enum está incorreto.');
    }
}

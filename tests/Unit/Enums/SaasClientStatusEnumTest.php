<?php

namespace Tests\Unit\Enums;

use App\Enums\SaasClient\SaasClientStatusEnum;
use PHPUnit\Framework\TestCase;

class SaasClientStatusEnumTest extends TestCase
{
    public function test_enum_values()
    {
        $expectedValues = ['active', 'active_testing', 'active_pending_payment', 'blocked', 'blocked_pending_payment', 'archived',];
        $enumValues = SaasClientStatusEnum::getValues();
        $this->assertEquals($expectedValues, $enumValues);
    }

    public function test_enum_cases()
    {
        $this->assertEquals(expected: 'active', actual: SaasClientStatusEnum::ACTIVE->value);
        $this->assertEquals(expected: 'active_testing', actual: SaasClientStatusEnum::ACTIVE_TESTING->value);
        $this->assertEquals(expected: 'active_pending_payment', actual: SaasClientStatusEnum::ACTIVE_PENDING_PAYMENT->value);
        $this->assertEquals(expected: 'blocked', actual: SaasClientStatusEnum::BLOCKED->value);
        $this->assertEquals(expected: 'blocked_pending_payment', actual: SaasClientStatusEnum::BLOCKED_PENDING_PAYMENT->value);
        $this->assertEquals(expected: 'archived', actual: SaasClientStatusEnum::ARCHIVED->value);
    }

    public function test_invalid_value()
    {
        $this->expectException(\Error::class);
        $invalidValue = SaasClientStatusEnum::INVALID_VALUE;
    }
}

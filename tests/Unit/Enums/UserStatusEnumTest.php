<?php

namespace Tests\Unit\Enums;

use App\Enums\User\UserStatusEnum;
use PHPUnit\Framework\TestCase;

class UserStatusEnumTest extends TestCase
{
    public function test_enum_values()
    {
        $expectedValues = ['active', 'blocked',];
        $enumValues = UserStatusEnum::getValues();
        $this->assertEquals($expectedValues, $enumValues);
    }

    public function test_enum_cases()
    {
        $this->assertEquals(expected: 'active', actual: UserStatusEnum::ACTIVE->value);
        $this->assertEquals(expected: 'blocked', actual: UserStatusEnum::BLOCKED->value);
    }

    public function test_invalid_value()
    {
        $this->expectException(\Error::class);
        $invalidValue = UserStatusEnum::INVALID_VALUE;
    }
}

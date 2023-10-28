<?php

namespace Tests\Unit\Enums;

use App\Enums\EventListItem\EventListItemPaymentStatusEnum;
use PHPUnit\Framework\TestCase;

class EventListItemPaymentStatusEnumTest extends TestCase
{
    public function test_enum_values()
    {
        $expectedValues = ['pending', 'canceled', 'paid',];
        $enumValues = EventListItemPaymentStatusEnum::getValues();
        $this->assertEquals($expectedValues, $enumValues);
    }

    public function test_enum_cases()
    {
        $this->assertEquals(expected: 'pending', actual: EventListItemPaymentStatusEnum::PENDING->value);
        $this->assertEquals(expected: 'canceled', actual: EventListItemPaymentStatusEnum::CANCELED->value);
        $this->assertEquals(expected: 'paid', actual: EventListItemPaymentStatusEnum::PAID->value);
    }

    public function test_invalid_value()
    {
        $this->expectException(\Error::class);
        $invalidValue = EventListItemPaymentStatusEnum::INVALID_VALUE;
    }
}

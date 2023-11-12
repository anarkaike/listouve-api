<?php

namespace Tests\Unit\Enums;

use App\Enums\EventListItem\EventListItemPaymentStatusEnum;
use PHPUnit\Framework\TestCase;

class EventListItemPaymentStatusEnumTest extends TestCase
{
    /**
     * Verifica o retorno de getValues do enum EventListItemPaymentStatusEnum
     * @test
     */
    public function check_if_event_list_item_payment_status_enum_is_correct(): void
    {
        $expectedValue = ['pending', 'canceled', 'paid',];
        $actualValue = EventListItemPaymentStatusEnum::getValues();

        $this->assertEquals(expected: $expectedValue, actual: $actualValue, message: 'Os valores do enum EventListItemPaymentStatusEnum está incorreto.');
    }

    /**
     * Verifica valor/nome a valor/nome do enum
     * @test
     */
    public function check_if_vars_of_event_list_item_payment_status_enum_is_correct(): void
    {
        $this->assertEquals(expected: 'pending', actual: EventListItemPaymentStatusEnum::PENDING->value, message: 'Valor do PENDING dentro do enum está incorreto.');
        $this->assertEquals(expected: 'canceled', actual: EventListItemPaymentStatusEnum::CANCELED->value, message: 'Valor do CANCELED dentro do enum está incorreto.');
        $this->assertEquals(expected: 'paid', actual: EventListItemPaymentStatusEnum::PAID->value, message: 'Valor do PAID dentro do enum está incorreto.');

        $this->assertEquals(expected: 'PENDING', actual: EventListItemPaymentStatusEnum::PENDING->name, message: 'Valor do PENDING dentro do enum está incorreto.');
        $this->assertEquals(expected: 'CANCELED', actual: EventListItemPaymentStatusEnum::CANCELED->name, message: 'Valor do CANCELED dentro do enum está incorreto.');
        $this->assertEquals(expected: 'PAID', actual: EventListItemPaymentStatusEnum::PAID->name, message: 'Valor do PAID dentro do enum está incorreto.');
    }
}

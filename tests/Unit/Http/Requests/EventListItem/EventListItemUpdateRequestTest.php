<?php

namespace Tests\Unit\Http\Requests\EventListItem;

use App\Enums\EventListItem\EventListItemPaymentStatusEnum;
use App\Http\Requests\EventListItem\EventListItemUpdateRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use PHPUnit\Framework\TestCase;

class EventListItemUpdateRequestTest extends TestCase
{
    /**
     * Verifica a integridade das regras d validação do request
     *
     * @test
     */
    public function check_if_rules_is_correct(): void
    {
        $expectedValue = [
            'event_id' => ['nullable', 'integer', Rule::exists(table: 'events', column: 'id'),],
            'event_list_id' => ['nullable', 'integer', Rule::exists(table: 'events_lists', column: 'id'),],
            'name' => ['nullable', 'string', 'max:255',],
            'email' => ['nullable', 'string', 'max:255',],
            'phone' => ['nullable', 'string', 'max:20',],
            'payment_status' => ['nullable', new Enum(EventListItemPaymentStatusEnum::class)],
            'saas_client_id' => ['nullable', 'integer'],
        ];
        $actualValue = (new EventListItemUpdateRequest)->rules();

        $this->assertEquals(expected: $expectedValue, actual: $actualValue, message: 'As regras de validação do request está diferente. Atualize o teste.');
    }
}

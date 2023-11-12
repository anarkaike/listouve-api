<?php

namespace Tests\Unit\Http\Requests\EventList;

use App\Http\Requests\EventList\EventListUpdateRequest;
use Illuminate\Validation\Rule;
use PHPUnit\Framework\TestCase;

class EventListUpdateRequestTest extends TestCase
{
    /**
     * Verifica a integridade das regras d validação do request
     *
     * @test
     */
    public function check_if_rules_is_correct(): void
    {
        $expectedValue = [
            'event_id' => ['required', 'integer', Rule::exists(table: 'events', column: 'id'),],
            'name' => ['required', 'string', 'max:255',],
            'description' => ['nullable', 'string',],
            'url_photo' => ['nullable', 'string', 'max:255',],
            'saas_client_id' => ['nullable', 'integer'],
        ];
        $actualValue = (new EventListUpdateRequest)->rules();

        $this->assertEquals(expected: $expectedValue, actual: $actualValue, message: 'As regras de validação do request está diferente. Atualize o teste.');
    }
}

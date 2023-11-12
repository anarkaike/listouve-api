<?php

namespace Tests\Unit\Http\Requests\Event;

use App\Http\Requests\Event\EventCreateRequest;
use PHPUnit\Framework\TestCase;

class EventCreateRequestTest extends TestCase
{
    /**
     * Verifica a integridade das regras d validação do request
     *
     * @test
     */
    public function check_if_rules_is_correct(): void
    {
        $expectedValue = [
            'name' => ['required', 'string', 'max:255',],
            'description' => ['nullable', 'string',],
            'url_photo' => ['nullable', 'string', 'max:255',],
            'saas_client_id' => ['required', 'integer'],
        ];
        $actualValue = (new EventCreateRequest)->rules();

        $this->assertEquals(expected: $expectedValue, actual: $actualValue, message: 'As regras de validação do request está diferente. Atualize o teste.');
    }
}

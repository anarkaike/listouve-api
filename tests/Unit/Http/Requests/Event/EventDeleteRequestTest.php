<?php

namespace Tests\Unit\Http\Requests\Event;

use App\Http\Requests\Event\EventDeleteRequest;
use PHPUnit\Framework\TestCase;

class EventDeleteRequestTest extends TestCase
{
    /**
     * Verifica a integridade das regras d validação do request
     *
     * @test
     */
    public function check_if_rules_is_correct(): void
    {
        $expectedValue = [];

        $actualValue = (new EventDeleteRequest)->rules();

        $this->assertEquals(expected: $expectedValue, actual: $actualValue, message: 'As regras de validação do request está diferente. Atualize o teste.');
    }
}

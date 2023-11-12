<?php

namespace Tests\Unit\Http\Requests\EventList;

use App\Http\Requests\EventList\EventListDeleteRequest;
use PHPUnit\Framework\TestCase;

class EventListDeleteRequestTest extends TestCase
{
    /**
     * Verifica a integridade das regras d validação do request
     *
     * @test
     */
    public function check_if_rules_is_correct(): void
    {
        $expectedValue = [];
        $actualValue = (new EventListDeleteRequest)->rules();

        $this->assertEquals(expected: $expectedValue, actual: $actualValue, message: 'As regras de validação do request está diferente. Atualize o teste.');
    }
}

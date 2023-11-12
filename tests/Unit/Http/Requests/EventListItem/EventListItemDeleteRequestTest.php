<?php

namespace Tests\Unit\Http\Requests\EventListItem;

use App\Http\Requests\EventListItem\EventListItemDeleteRequest;
use PHPUnit\Framework\TestCase;

class EventListItemDeleteRequestTest extends TestCase
{
    /**
     * Verifica a integridade das regras d validação do request
     *
     * @test
     */
    public function check_if_rules_is_correct(): void
    {
        $expectedValue = [];
        $actualValue = (new EventListItemDeleteRequest)->rules();

        $this->assertEquals(expected: $expectedValue, actual: $actualValue, message: 'As regras de validação do request está diferente. Atualize o teste.');
    }
}

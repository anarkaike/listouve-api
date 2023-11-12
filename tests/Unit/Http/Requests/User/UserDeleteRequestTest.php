<?php

namespace Tests\Unit\Http\Requests\User;

use App\Http\Requests\User\UserDeleteRequest;
use PHPUnit\Framework\TestCase;

class UserDeleteRequestTest extends TestCase
{
    /**
     * Verifica a integridade das regras d validação do request
     *
     * @test
     */
    public function check_if_rules_is_correct(): void
    {
        $expectedValue = [];
        $actualValue = (new UserDeleteRequest)->rules();

        $this->assertEquals(expected: $expectedValue, actual: $actualValue, message: 'As regras de validação do request está diferente. Atualize o teste.');
    }
}

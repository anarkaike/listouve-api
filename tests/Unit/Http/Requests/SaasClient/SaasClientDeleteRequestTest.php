<?php

namespace Tests\Unit\Http\Requests\SaasClient;

use App\Http\Requests\SaasClient\SaasClientDeleteRequest;
use PHPUnit\Framework\TestCase;

class SaasClientDeleteRequestTest extends TestCase
{
    /**
     * Verifica a integridade das regras d validação do request
     *
     * @test
     */
    public function check_if_rules_is_correct(): void
    {
        $expectedValue = [];
        $actualValue = (new SaasClientDeleteRequest)->rules();

        $this->assertEquals(expected: $expectedValue, actual: $actualValue, message: 'As regras de validação do request está diferente. Atualize o teste.');
    }
}

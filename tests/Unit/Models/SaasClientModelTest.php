<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use App\Models\SaasClient;

class SaasClientModelTest extends TestCase
{
    /**
     * Verificando se os campos preenchiveis configurads no model sào os citados abaixo
     *
     * @test
     */
    public function check_if_fillable_fields_is_corect(): void
    {
        $expectedValue = [
            'name',
            'email_personal',
            'email_pofessional',
            'phone_personal',
            'phone_pofessional',
            'observation',
            'status',
            'created_by',
            'updated_by',
            'updated_at',
            'updated_values',
            'deleted_at',
            'deleted_by',
        ];

        $modelToTest    = new SaasClient;
        $actualValues   = $modelToTest->getFillable();
        $arrayDiff      = array_diff($expectedValue, $actualValues);

        $this->assertEquals(expected: 0, actual: count($arrayDiff), message: 'Campos preenchiveis não estão corretos no model.');
    }

    /**
     * Verifica se a lista de campos ocultos são os citados na lista abaixo
     *
     * @test
     */
    public function check_if_hidden_fields_is_corect(): void
    {
        $expectedValue = [];

        $modelToTest    = new SaasClient;
        $actualValues   = $modelToTest->getHidden();
        $arrayDiff      = array_diff($expectedValue, $actualValues);

        $this->assertEquals(expected: 0, actual: count($arrayDiff), message: 'Campos ocultos não estão corretos no model.');
    }
}

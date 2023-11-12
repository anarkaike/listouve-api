<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use App\Models\Event;

class EventModelTest extends TestCase
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
            'description',
            'url_photo',
            'saas_client_id',
            'created_by',
            'updated_at',
            'updated_by',
            'updated_values',
            'deleted_at',
            'deleted_by',
        ];

        $modelToTest    = new Event;
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

        $modelToTest    = new Event;
        $actualValues   = $modelToTest->getHidden();
        $arrayDiff      = array_diff($expectedValue, $actualValues);

        $this->assertEquals(expected: 0, actual: count($arrayDiff), message: 'Campos ocultos não estão corretos no model.');
    }
}

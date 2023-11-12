<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use App\Models\User;

class UserModelTest extends TestCase
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
            'email',
            'password',
            'phone_personal',
            'phone_professional',
            'url_photo',
            'status',
            'created_by',
            'updated_at',
            'updated_by',
            'updated_values',
            'deleted_at',
            'deleted_by',
        ];

        $modelToTest    = new User;
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
        $expectedValue = [
            'password',
            'remember_token',
        ];

        $modelToTest    = new User;
        $actualValues   = $modelToTest->getHidden();
        $arrayDiff      = array_diff($expectedValue, $actualValues);

        $this->assertEquals(expected: 0, actual: count($arrayDiff), message: 'Campos ocultos não estão corretos no model.');
    }
}

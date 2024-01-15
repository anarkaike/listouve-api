<?php

namespace App\Enums\SaasClient;

enum SaasClientBusinessSectorEnum: string
{
    case BAR = 'bar';
    case BOATE = 'boate';
    case PRODUTOR_DE_FESTAS = 'produtor_de_festas';
    case CERIMONIALISA = 'cerimonialista';
    case OUTROS = 'outros';

    public static function getValues()
    {
        return [
            self::BAR->value,
            self::BOATE->value,
            self::PRODUTOR_DE_FESTAS->value,
            self::CERIMONIALISA->value,
            self::OUTROS->value,
        ];
    }
}

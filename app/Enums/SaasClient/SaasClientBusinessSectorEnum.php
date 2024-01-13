<?php

namespace App\Enums\SaasClient;

enum SaasClientBusinessSectorEnum: string
{
    case BAR = 'Bar';
    case BOATE = 'Boate';
    case PRODUTOR_DE_FESTAS = 'Produtor de Festas';
    case CERIMONIALISA = 'Cerimonialista';
    case OUTROS = 'Outros';

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

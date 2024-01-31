<?php

namespace App\Enums\Profile;

enum ProfileIdsEnum: int
{
    case ADMIN_SAAS = 1;
    case REVENDEDOR_SAAS = 2;
    case DONO_ESTABELECIMENTO = 3;
    case PRODUTOR_DE_FESTAS = 4;
    case CERIMONIALISTA = 5;
    case RECEPCIONISTA = 6;
    case PROMOTER = 7;
    case CONVIDADO = 8;

    public static function getValues()
    {
        return [
            self::ADMIN_SAAS->value,
            self::REVENDEDOR_SAAS->value,
            self::DONO_ESTABELECIMENTO->value,
            self::PRODUTOR_DE_FESTAS->value,
            self::CERIMONIALISTA->value,
            self::RECEPCIONISTA->value,
            self::PROMOTER->value,
            self::CONVIDADO->value,
        ];
    }
}

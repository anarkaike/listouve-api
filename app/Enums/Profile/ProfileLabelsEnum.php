<?php

namespace App\Enums\Profile;

enum ProfileLabelsEnum: string
{
    case ADMIN_SAAS = 'Admin SaaS';
    case REVENDEDOR_SAAS = 'Revendedor SaaS';
    case DONO_ESTABELECIMENTO = 'Dono de Estabelecimento';
    case PRODUTOR_DE_FESTAS = 'Produtor de Festas';
    case CERIMONIALISTA = 'Cerimonialista';
    case RECEPCIONISTA = 'Recepcionista';
    case PROMOTER = 'Promoter';
    case CONVIDADO = 'Convidado';

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

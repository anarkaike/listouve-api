<?php

namespace App\Enums\EventListItem;


enum EventListItemPaymentStatusEnum: string
{
    case PENDING = 'pending'; // Nome na lista pendente de pagamento
    case CANCELED = 'canceled'; // Nome na lista cancelado
    case PAID = 'paid'; // Nome na lista com pagamento feito

    public static function getValues()
    {
        return [
            self::PENDING->value,
            self::CANCELED->value,
            self::PAID->value,
        ];
    }
}

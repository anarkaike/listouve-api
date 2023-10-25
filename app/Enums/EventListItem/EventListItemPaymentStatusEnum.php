<?php

namespace App\Enums\EventListItem;

enum EventListItemPaymentStatusEnum: string
{
    case PENDING = 'pending';
    case CANCELED = 'canceled';
    case PAID = 'paid';

    public static function getValues()
    {
        return [
            self::PENDING,
            self::CANCELED,
            self::PAID,
        ];
    }
}

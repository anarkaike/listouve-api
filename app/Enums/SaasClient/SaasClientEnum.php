<?php

namespace App\Enums\SaasClient;

enum SaasClientEnum: string
{
    case ACTIVE_TESTING = 'active_testing';
    case ACTIVE = 'active';
    case BLOCKED = 'blocked';
    case BLOCKED_BY_PAYMENT = 'blocked_by_payment';
    case PENDING_PAYMENT = 'pending_payment';

    public static function getValues()
    {
        return [
            self::ACTIVE_TESTING,
            self::ACTIVE,
            self::BLOCKED,
            self::BLOCKED_BY_PAYMENT,
            self::PENDING_PAYMENT,
        ];
    }
}

<?php

namespace App\Enums\User;

enum UserStatusEnum: string
{
    case ACTIVE = 'active';
    case BLOCKED = 'blocked';

    public static function getValues()
    {
        return [
            self::ACTIVE,
            self::BLOCKED,
        ];
    }
}

<?php

namespace App\Enums\User;

enum UserStatusEnum: string
{
    case ACTIVE = 'active'; // Usuário ativo
    case BLOCKED = 'blocked'; // Usuário bloqueado

    public static function getValues()
    {
        return [
            self::ACTIVE->value,
            self::BLOCKED->value,
        ];
    }
}

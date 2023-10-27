<?php

namespace App\Enums\User;

/**
 * Enum contendo as possibilidades da coluna status da entidade users
 */
enum UserStatusEnum: string
{
    case ACTIVE = 'active'; // Usuário ativo
    case BLOCKED = 'blocked'; // Usuário bloqueado

    public static function getValues()
    {
        return [
            self::ACTIVE,
            self::BLOCKED,
        ];
    }
}

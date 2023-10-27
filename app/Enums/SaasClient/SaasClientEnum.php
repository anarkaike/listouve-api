<?php

namespace App\Enums\SaasClient;

/**
 * Enum contendo as possibilidades da coluna status da entidade saas_clients
 */
enum SaasClientEnum: string
{
    case ACTIVE = 'active'; // Sistema do cliente saas Ativo
    case ACTIVE_TESTING = 'active_testing'; // Sistema do client saas em periodo de teste
    case ACTIVE_PENDING_PAYMENT = 'active_pending_payment'; // Sistema do cliente saas ativo, mesmo pendente de pagamento (mostrando mensagem)
    case BLOCKED = 'blocked'; // Sistema do cliente saas bloqueado sem motivo especifico
    case BLOCKED_PENDING_PAYMENT = 'blocked_pending_payment'; // Sistema do cliente saas bloqueado por falta de pagamento
    case ARCHIVED = 'archived'; // Sistema do cliente arquivado

    public static function getValues()
    {
        return [
            self::ACTIVE,
            self::ACTIVE_TESTING,
            self::ACTIVE_PENDING_PAYMENT,
            self::BLOCKED,
            self::BLOCKED_PENDING_PAYMENT,
            self::ARCHIVED,
        ];
    }
}

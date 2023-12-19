<?php

namespace App\Enums\SaasClient;

enum SaasClientStatusEnum: string
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
            self::ACTIVE->value,
            self::ACTIVE_TESTING->value,
            self::ACTIVE_PENDING_PAYMENT->value,
            self::BLOCKED->value,
            self::BLOCKED_PENDING_PAYMENT->value,
            self::ARCHIVED->value,
        ];
    }
}

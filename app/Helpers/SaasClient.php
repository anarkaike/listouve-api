<?php

namespace App\Helpers;

class SaasClient {
    static function getDomainAccessByHaeder($fullUrl = null) {
        $fullUrl = $fullUrl ?? @$_SERVER['HTTP_X_JC_CURRENT_DOMAIN'] ?? null;
        return $fullUrl ? Domain::getDomainByFullUrl($fullUrl) : null;
    }
}

<?php

namespace App\Helpers;

class SaasClient {
    static function getDomainAccessByHaeder($fullUrl = null) {
        $fullUrl = $fullUrl ?? @$_SERVER['HTTP_X_JC_CURRENT_DOMAIN'] ?? null;
        return $fullUrl ? Domain::getDomainByFullUrl($fullUrl) : null;
    }

    static function getSaasClientByHeaderVar() {
        $saasClient = \App\Models\SaasClient::where('domain_front', self::getDomainAccessByHaeder())->get()->first();
        return $saasClient ?? null;
    }
}

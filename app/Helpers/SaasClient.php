<?php

namespace App\Helpers;

class SaasClient {
    static function getDomainAccessByHaeder($fullUrl = null) {
        $fullUrl = $fullUrl ?? @$_SERVER['HTTP_X_JC_CURRENT_DOMAIN'] ?? null;
        return $fullUrl ? Domain::getDomainByFullUrl($fullUrl) : null;
    }

    static function getSaasClientByHeaderVar() {
        if (isset($_SERVER['HTTP_X_JC_SAASCLIENT_ID'])) {
            return \App\Models\SaasClient::where('id', $_SERVER['HTTP_X_JC_SAASCLIENT_ID'])->get()->first();
        }
        $saasClient = \App\Models\SaasClient::where('domain_front', self::getDomainAccessByHaeder())->get()->first();
        return $saasClient ?? null;
    }
}

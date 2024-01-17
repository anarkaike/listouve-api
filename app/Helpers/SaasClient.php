<?php

namespace App\Helpers;

class SaasClient {
    static function getDomainAccessByHaeder($fullUrl = null) {
        return Domain::getDomainByFullUrl($fullUrl ?? $_SERVER['HTTP_X_JC_CURRENT_DOMAIN']);
    }
}

<?php

namespace App\Helpers;

class Domain {
    static function getDomainByFullUrl(string $fullUrl = null) {
        $url = explode('/', $fullUrl);
        if (strpos($url[2], ':') !== -1) {
            $url = explode(':', $url[2]);
            $domain = $url[0];
        } else {
            $domain = $url[2];
        }
        return $domain;
    }
}

<?php

namespace App\Http\Controllers;

use App\Helpers\SaasClient;
use App\Services\Upload;
use Illuminate\Http\Request;
use Illuminate\{
    Foundation\Auth\Access\AuthorizesRequests,
    Foundation\Validation\ValidatesRequests,
    Routing\Controller as BaseController,
};

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function upload (string $paramName, Request $request, string $sufixUp = '_up') {
        $file = $request->file($paramName . $sufixUp);
        if ($file) {
            return $data[$paramName] = Upload::uploadFile($file);
        }
        return $request->get($paramName);
    }

    protected function formatDateToDb($date) {
        return \Carbon\Carbon::parse(str_replace('/', '-', $date))->format('Y-m-d H:i:s');
    }

    protected function getSaasClientId() {
        return SaasClient::getSaasClientByHeaderVar()?->id;
    }
}

<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiErrorResponse;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        $msg = 'Token necessário para acssar end point.';
        return $request->expectsJson() ? null : (new ApiErrorResponse(new \Exception($msg)))->toResponse();
    }
}

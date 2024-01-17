<?php

namespace App\Http\Middleware;

use App\Helpers\SaasClient;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SaaSFiltering
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
//        $guards = empty($guards) ? [null] : $guards;
//
//        foreach ($guards as $guard) {
//            if (Auth::guard($guard)->check()) {
//                return redirect(to: RouteServiceProvider::HOME);
//            }
//        }
        $domain = SaasClient::getDomainAccessByHaeder();

//        exit($domain);

        return $next($request);
    }
}

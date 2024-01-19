<?php

namespace App\Http\Middleware;

use App\Helpers\SaasClient as SaasClientHelper;
use App\Models\Event;
use App\Models\EventList;
use App\Models\EventListItem;
use App\Models\SaasClient;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\Builder;

class SaaSFiltering
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $saasClient = SaasClientHelper::getSaasClientByHeaderVar();
        if ($saasClient) {
            Event::addGlobalScope('saas_client_id', function (Builder $builder) use ($saasClient) {
                $builder->where('saas_client_id', $saasClient->id);
            });
            EventList::addGlobalScope('saas_client_id', function (Builder $builder) use ($saasClient) {
                $builder->where('saas_client_id', $saasClient->id);
            });
            EventListItem::addGlobalScope('saas_client_id', function (Builder $builder) use ($saasClient) {
                $builder->where('saas_client_id', $saasClient->id);
            });
        }

        return $next($request);
    }
}

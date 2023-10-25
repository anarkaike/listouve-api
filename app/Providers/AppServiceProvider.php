<?php

namespace App\Providers;

use App\Actions\EventAction;
use App\Actions\EventListAction;
use App\Actions\EventListItemAction;
use App\Actions\SaasClientAction;
use App\Actions\UserAction;
use App\Contracts\Actions\EventActionInterface;
use App\Contracts\Actions\EventListActionInterface;
use App\Contracts\Actions\EventListItemActionInterface;
use App\Contracts\Actions\SaasClientActionInterface;
use App\Contracts\Actions\UserActionInterface;
use App\Contracts\Repositories\EventListItemRepositoryInterface;
use App\Contracts\Repositories\EventListRepositoryInterface;
use App\Contracts\Repositories\EventRepositoryInterface;
use App\Contracts\Repositories\SaasClientRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Repositories\EventListItemRepository;
use App\Repositories\EventListRepository;
use App\Repositories\EventRepository;
use App\Repositories\SaasClientRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        // Repositories Interfaces
        $this->app->bind(abstract: UserRepositoryInterface::class, concrete: UserRepository::class);
        $this->app->bind(abstract: EventRepositoryInterface::class, concrete: EventRepository::class);
        $this->app->bind(abstract: EventListRepositoryInterface::class, concrete: EventListRepository::class);
        $this->app->bind(abstract: EventListItemRepositoryInterface::class, concrete: EventListItemRepository::class);
        $this->app->bind(abstract: SaasClientRepositoryInterface::class, concrete: SaasClientRepository::class);


        // Actions Interfaces
        $this->app->bind(abstract: UserActionInterface::class, concrete: UserAction::class);
        $this->app->bind(abstract: EventActionInterface::class, concrete: EventAction::class);
        $this->app->bind(abstract: EventListActionInterface::class, concrete: EventListAction::class);
        $this->app->bind(abstract: EventListItemActionInterface::class, concrete: EventListItemAction::class);
        $this->app->bind(abstract: SaasClientActionInterface::class, concrete: SaasClientAction::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

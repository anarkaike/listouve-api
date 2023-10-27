<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Actions\{
    EventAction,
    EventListAction,
    EventListItemAction,
    SaasClientAction,
    UserAction,
};
use App\Contracts\Actions\{
    EventActionInterface,
    EventListActionInterface,
    EventListItemActionInterface,
    SaasClientActionInterface,
    UserActionInterface,
};
use App\Contracts\Repositories\{
    EventListItemRepositoryInterface,
    EventListRepositoryInterface,
    EventRepositoryInterface,
    SaasClientRepositoryInterface,
    UserRepositoryInterface,
};
use App\Repositories\{
    EventListItemRepository,
    EventListRepository,
    EventRepository,
    SaasClientRepository,
    UserRepository,
};

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

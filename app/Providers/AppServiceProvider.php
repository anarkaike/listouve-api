<?php

namespace App\Providers;

use App\Broadcasting\Channels\MailjetChannel;
use App\Services\Integrations\MailjetService;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use App\Actions\{Bi\EventBiAction,
    Bi\EventListBiAction,
    Bi\EventListItemBiAction,
    Bi\SaasClientBiAction,
    Bi\UserBiAction,
    EventAction,
    EventListAction,
    EventListItemAction,
    SaasClientAction,
    UserAction};
use App\Contracts\Actions\{Bi\EventBiActionInterface,
    Bi\EventListBiActionInterface,
    Bi\EventListItemBiActionInterface,
    Bi\SaasClientBiActionInterface,
    Bi\UserBiActionInterface,
    EventActionInterface,
    EventListActionInterface,
    EventListItemActionInterface,
    SaasClientActionInterface,
    UserActionInterface};
use App\Contracts\Repositories\{Bi\EventBiRepositoryInterface,
    Bi\EventListBiRepositoryInterface,
    Bi\EventListItemBiRepositoryInterface,
    Bi\SaasClientBiRepositoryInterface,
    Bi\UserBiRepositoryInterface,
    EventListItemRepositoryInterface,
    EventListRepositoryInterface,
    EventRepositoryInterface,
    SaasClientRepositoryInterface,
    UserRepositoryInterface};
use App\Repositories\{Bi\EventBiRepository,
    Bi\EventListBiRepository,
    Bi\EventListItemBiRepository,
    Bi\SaasClientBiRepository,
    Bi\UserBiRepository,
    EventListItemRepository,
    EventListRepository,
    EventRepository,
    SaasClientRepository,
    UserRepository};

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
        // Bi
        $this->app->bind(abstract: UserBiRepositoryInterface::class, concrete: UserBiRepository::class);
        $this->app->bind(abstract: EventBiRepositoryInterface::class, concrete: EventBiRepository::class);
        $this->app->bind(abstract: EventListBiRepositoryInterface::class, concrete: EventListBiRepository::class);
        $this->app->bind(abstract: EventListItemBiRepositoryInterface::class, concrete: EventListItemBiRepository::class);
        $this->app->bind(abstract: SaasClientBiRepositoryInterface::class, concrete: SaasClientBiRepository::class);

        // Bi
        $this->app->bind(abstract: UserBiActionInterface::class, concrete: UserBiAction::class);
        $this->app->bind(abstract: EventBiActionInterface::class, concrete: EventBiAction::class);
        $this->app->bind(abstract: EventListBiActionInterface::class, concrete: EventListBiAction::class);
        $this->app->bind(abstract: EventListItemBiActionInterface::class, concrete: EventListItemBiAction::class);
        $this->app->bind(abstract: SaasClientBiActionInterface::class, concrete: SaasClientBiAction::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        $this->app->when(concrete: MailjetChannel::class)
            ->needs(abstract: MailChannel::class)
            ->give(function () {
                return $this->app->make(abstract: 'mailjet')->getSwiftMailer();
            });


        Notification::extend(driver: 'mailjet', callback: function ($app) {
            return new MailjetChannel(mailjet: new MailjetService);
        });
    }
}

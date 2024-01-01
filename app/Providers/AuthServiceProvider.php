<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\{
    User,
    Event,
    EventList,
    EventListItem,
    Permission,
    Profile,
    SaasClient,
};
use App\Policies\{
    EventListItemPolicy,
    EventListPolicy,
    EventPolicy,
    PermissionPolicy,
    ProfilePolicy,
    SaasClientPolicy,
    UserPolicy,
};

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        SaasClient::class       => SaasClientPolicy::class,
        User::class             => UserPolicy::class,
        Profile::class          => ProfilePolicy::class,
        Permission::class       => PermissionPolicy::class,
        Event::class            => EventPolicy::class,
        EventList::class        => EventListPolicy::class,
        EventListItem::class    => EventListItemPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define(ability: 'users', callback: function (User $user, User $record) {
            return $user->id === $record->created_by;
        });
        Gate::define(ability: 'users:just-mine', callback: function (User $user, User $record) {
            return $user->id === $record->created_by;
        });
    }
}

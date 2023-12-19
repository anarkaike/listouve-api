<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
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

<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Illuminate\Auth\Access\Response;

use App\Models\User;
use App\Models\Contracts\Item;
use App\Enums\Access as AccessEnum;


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
        Gate::define('change-access', function (User $user, Item $item, AccessEnum $accessType) {
            return $item->getAccessForUser($user->id)[$accessType->value]
                ? Response::allow()
                : Response::deny("You don't have access rights to this item");
        });
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Illuminate\Auth\Access\Response;

use App\Models\User;
use App\Models\File;
use App\Models\Contracts\Item;
use App\Enums\Access as AccessEnum;
use App\Policies\FilePolicy;



class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        File::class => FilePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('change-access', function (User $user, Item $item, AccessEnum $accessType) {
            return $item->getAccessesForUser($user->id)[$accessType->value]
                ? Response::allow()
                : Response::deny("You don't have access rights to this item");
        });

        Gate::define('rename', function (User $user, Item $item) {
            return $item->getAccessesForUser($user->id)[AccessEnum::Write->value]
                ? Response::allow()
                : Response::deny("You don't have write permission to this item");
        });
    }
}

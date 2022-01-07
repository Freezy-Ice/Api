<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Shop;
use App\Models\User;
use App\Policies\ShopPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Shop::class => ShopPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define("is-admin", fn(User $user): bool => $user->isAdmin());

        Gate::before(function (User $user) {
            if ($user->isAdmin()) {
                return true;
            }
        });
    }
}

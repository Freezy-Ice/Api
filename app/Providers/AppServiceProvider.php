<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\IceCreamShop;
use App\Observers\IceCreamShopObserver;
use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\TelescopeServiceProvider as BaseTelescopeServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->environment("local")) {
            $this->app->register(BaseTelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    public function boot(): void
    {
        IceCreamShop::observe(IceCreamShopObserver::class);
    }
}

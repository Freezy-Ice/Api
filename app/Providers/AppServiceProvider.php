<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Product;
use App\Models\Review;
use App\Observers\ProductObserver;
use App\Observers\ReviewObserver;
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
        Product::observe(ProductObserver::class);
        Review::observe(ReviewObserver::class);
    }
}

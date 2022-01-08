<?php

declare(strict_types=1);

namespace App\Providers;

use App\Events\ProductCreated;
use App\Events\ProductDeleted;
use App\Events\ProductUpdated;
use App\Events\ShopUpdated;
use App\Notifications\ProductCreated as ProductCreatedNotification;
use App\Notifications\ProductDeleted as ProductDeletedNotification;
use App\Notifications\ProductUpdated as ProductUpdatedNotification;
use App\Notifications\ShopUpdated as ShopUpdatedNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [];

    public function boot(): void
    {
        Event::listen(function (ProductCreated $event): void {
            foreach ($event->product->shop->favorites()->notifiables()->get() as $favorite) {
                $favorite->notify(new ProductCreatedNotification($event->product));
            }
        });

        Event::listen(function (ProductUpdated $event): void {
            foreach ($event->product->shop->favorites()->notifiables()->get() as $favorite) {
                $favorite->notify(new ProductUpdatedNotification($event->product));
            }
        });

        Event::listen(function (ProductDeleted $event): void {
            foreach ($event->product->shop->favorites()->notifiables()->get() as $favorite) {
                $favorite->notify(new ProductDeletedNotification($event->product));
            }
        });

        Event::listen(function (ShopUpdated $event): void {
            foreach ($event->shop->favorites()->notifiables()->get() as $favorite) {
                $favorite->notify(new ShopUpdatedNotification($event->shop));
            }
        });
    }
}

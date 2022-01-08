<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Shop;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ShopUpdated extends Notification
{
    public function __construct(
        protected Shop $shop,
    ) {
    }

    public function via(): array
    {
        return ["mail"];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage())
            ->subject(__("Shop \":name\" has been updated", [
                "name" => $this->shop->name,
            ]))
            ->line(__("Shop \":name\" has been updated", [
                "name" => $this->shop->name,
            ]))
            ->action(__("Go to shop"), config("services.shop_url") . $this->shop->id);
    }
}

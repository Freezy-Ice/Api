<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductCreated extends Notification
{
    public function __construct(
        protected Product $product,
    ) {
    }

    public function via(): array
    {
        return ["mail"];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage())
            ->subject(__("Shop \":name\": added new product", [
                "name" => $this->product->shop->name,
            ]))
            ->line(__("Product \":name\" has been created", [
                "name" => $this->product->name,
            ]))
            ->action(__("Go to shop"), config("services.shop_url") . $this->product->shop->id);
    }
}

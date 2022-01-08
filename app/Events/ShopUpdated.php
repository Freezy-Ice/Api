<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Shop;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ShopUpdated
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Shop $shop,
    ) {
    }
}

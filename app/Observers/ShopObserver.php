<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Shop;

class ShopObserver
{
    public function deleted(Shop $product): void
    {
        $product->image()->delete();
    }
}

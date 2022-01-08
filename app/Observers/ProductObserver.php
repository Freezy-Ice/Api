<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Product;
use App\Models\Shop;

class ProductObserver
{
    public function created(Product $product): void
    {
        $product->shop->avg_price = $this->calculateAvgPrice($product->shop);
        $product->shop->save();
    }

    public function updated(Product $product): void
    {
        $product->shop->avg_price = $this->calculateAvgPrice($product->shop);
        $product->shop->save();
    }

    public function deleted(Product $product): void
    {
        $product->shop->avg_price = $this->calculateAvgPrice($product->shop);
        $product->shop->save();

        $product->image()->delete();
    }

    public function calculateAvgPrice(Shop $shop): float
    {
        return round((float)$shop->products()->avg("price"));
    }
}

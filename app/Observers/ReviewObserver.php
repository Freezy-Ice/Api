<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Review;
use App\Models\Shop;

class ReviewObserver
{
    public function created(Review $review): void
    {
        $review->shop->rating = $this->calculateRating($review->shop);
        $review->shop->save();
    }

    public function deleted(Review $review): void
    {
        $review->shop->rating = $this->calculateRating($review->shop);
        $review->shop->save();
    }

    public function calculateRating(Shop $shop): float
    {
        return round($shop->reviews()->avg("rating") * 2) / 2;
    }
}

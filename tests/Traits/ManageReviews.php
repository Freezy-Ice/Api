<?php

declare(strict_types=1);

namespace Tests\Traits;

use App\Models\Review;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Collection;

trait ManageReviews
{
    public function createReview(array $data = []): Review
    {
        /** @var Review $review */
        $review = Review::factory($data)
            ->create();

        return $review;
    }

    public function createReviewFor(Shop $shop, array $data = []): Review
    {
        /** @var Review $review */
        $review = Review::factory($data)
            ->for($shop)
            ->create();

        return $review;
    }

    public function createReviews(int $count = 5, array $data = []): Collection
    {
        return Review::factory($data)
            ->count($count)
            ->create();
    }

    public function createReviewsFor(Shop $shop, int $count = 5, array $data = []): Collection
    {
        return Review::factory($data)
            ->count($count)
            ->for($shop)
            ->create();
    }

    public function reviewShop(User $user, Shop $shop, array $data = []): Review
    {
        /** @var Review $review */
        $review = Review::factory($data)
            ->for($user)
            ->for($shop)
            ->create();

        return $review;
    }

    public function clearUserReview(User $user, Shop $shop): void
    {
        $user->reviews()->where("shop_id", $shop->id)->delete();
    }
}

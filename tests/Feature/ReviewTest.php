<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CreatesShops;
use Tests\Traits\CreatesUsers;
use Tests\Traits\ManageReviews;

class ReviewTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;
    use CreatesShops;
    use ManageReviews;

    public function testUserCanListReviews(): void
    {
        $user = $this->createUser();
        $shop = $this->createShop();
        $this->createReviewsFor($shop, 10);
        $this->reviewShop($user, $shop);

        $this->assertDatabaseCount("reviews", 11);

        $this->actingAs($user)
            ->get("me/reviews")
            ->assertSuccessful()
            ->assertJsonCount(1, "data");
    }

    public function testUserCanReviewShop(): void
    {
        $user = $this->createUser();
        $shop = $this->createShop();

        $this->assertDatabaseCount("reviews", 0);

        $this->actingAs($user)
            ->post("/shops/{$shop->id}/review", [
                "rating" => 3,
                "comment" => "lorem ipsum",
            ])
            ->assertSuccessful();

        $this->assertDatabaseCount("reviews", 1);

        $this->assertDatabaseHas("reviews", [
            "user_id" => $user->id,
            "shop_id" => $shop->id,
            "rating" => 3,
            "comment" => "lorem ipsum",
        ]);
    }

    public function testUserCanDeleteReview(): void
    {
        $user = $this->createUser();
        $shop = $this->createShop();

        $this->reviewShop($user, $shop);

        $this->assertDatabaseCount("reviews", 1);

        $this->actingAs($user)
            ->delete("/shops/{$shop->id}/review")
            ->assertSuccessful();

        $this->assertDatabaseCount("reviews", 0);
    }
}

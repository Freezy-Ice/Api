<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

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

    public function testAdminCanListAllReviews(): void
    {
        $user = $this->createAdmin();
        $this->createReviews(10);

        $this->assertDatabaseCount("reviews", 10);

        $this->actingAs($user)
            ->get("admin/reviews")
            ->assertSuccessful()
            ->assertJsonCount(10, "data");
    }

    public function testAdminCanDeleteReview(): void
    {
        $user = $this->createAdmin();
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
        $user = $this->createAdmin();
        $review = $this->createReview();

        $this->assertDatabaseCount("reviews", 1);

        $this->actingAs($user)
            ->delete("/admin/reviews/{$review->id}")
            ->assertSuccessful();

        $this->assertDatabaseCount("reviews", 0);
    }
}

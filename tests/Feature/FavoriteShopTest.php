<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CreatesShops;
use Tests\Traits\CreatesUsers;
use Tests\Traits\ManagesFavorites;

class FavoriteShopTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;
    use CreatesShops;
    use ManagesFavorites;

    public function testUserCanListFavoriteShops(): void
    {
        $user = $this->createUser();
        $shop = $this->createShop();
        $this->createShops(10);
        $this->likeShop($user, $shop);

        $this->assertDatabaseCount("shops", 11);

        $this->actingAs($user)
            ->get("me/favorites")
            ->assertSuccessful()
            ->assertJsonCount(1, "data");
    }

    public function testUserCanLikeShop(): void
    {
        $user = $this->createUser();
        $shop = $this->createShop();

        $this->assertCount(0, $user->favoriteShops()->get());

        $this->actingAs($user)
            ->post("/shops/{$shop->id}/like")
            ->assertSuccessful();

        $this->assertCount(1, $user->favoriteShops()->get());
    }

    public function testUserCanDislikeShop(): void
    {
        $user = $this->createUser();
        $shop = $this->createShop();

        $this->likeShop($user, $shop);

        $this->assertCount(1, $user->favoriteShops()->get());

        $this->actingAs($user)
            ->delete("/shops/{$shop->id}/like")
            ->assertSuccessful();

        $this->assertCount(0, $user->favoriteShops()->get());
    }
}

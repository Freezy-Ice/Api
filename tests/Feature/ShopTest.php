<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CreatesImages;
use Tests\Traits\CreatesUsers;
use Tests\Traits\CreatesShops;
use Tests\Traits\CreatesCities;

class ShopTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;
    use CreatesCities;
    use CreatesShops;
    use CreatesImages;

    public function testUserCanSeeOwnedShops(): void
    {
        $user = $this->createCompanyUser();
        $this->createShopsFor($user, 3);
        $this->createShops(10);

        $this->assertDatabaseCount("shops", 13);

        $this->actingAs($user)
            ->get('/business/shops')
            ->assertSuccessful()
            ->assertJsonCount(3, "data");
    }

    public function testUserCanCreateShop(): void
    {
        $user = $this->createCompanyUser();
        $city = $this->createCity();

        $this->actingAs($user)
            ->post("/business/shops", [
                "name" => "Shop name",
                "city" => $city->id,
                "address" => "Street, building number",
                "description" => "Description",
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas("shops", [
            "user_id" => $user->id,
            "name" => "Shop name",
            "city_id" => $city->id,
            "address" => "Street, building number",
            "description" => "Description",
            "lat" => null,
            "lng" => null,
            "rating" => 0,
            "avg_price" => 0,
            "accepted" => 0,
        ]);
    }

    public function testUserCanSeeShop(): void
    {
        $user = $this->createCompanyUser();
        $shop = $this->createShopFor($user);

        $this->actingAs($user)
            ->get("/business/shops/{$shop->id}")
            ->assertSuccessful()
            ->assertJsonFragment([
                "id" => $shop->id
            ]);
    }

    public function testUserCanUpdateShop(): void
    {
        $user = $this->createCompanyUser();
        $shop = $this->createShopFor($user);
        $city = $this->createCity();
        $image = $this->createImage();

        $this->actingAs($user)
            ->put("/business/shops/{$shop->id}", [
                "name" => "New name",
                "city" => $city->id,
                "address" => "New address",
                "description" => "New description",
                "image" => $image->id,
                "coords" => [
                    "lat" => "12.34",
                    "lng" => "12.34",
                ],
                "openingHours" => [
                    [
                        "day" => "monday",
                        "from" => "08:00",
                        "to" => "16:00",
                        "open" => true
                    ],
                ],
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas("shops", [
            "name" => "New name",
            "city_id" => $city->id,
            "address" => "New address",
            "description" => "New description",
            "lat" => "12.34",
            "lng" => "12.34",
            "rating" => 0,
            "avg_price" => 0,
            "accepted" => 1,
        ]);

        $this->assertDatabaseHas("opening_hours", [
            "day" => "monday",
            "from" => "08:00",
            "to" => "16:00",
            "open" => true,
        ]);
    }

    public function testUserCanDeleteShop(): void
    {
        $user = $this->createCompanyUser();
        $shop = $this->createShopFor($user);

        $this->assertModelExists($shop);

        $this->actingAs($user)
            ->delete("/business/shops/{$shop->id}")
            ->assertSuccessful();

        $this->assertDeleted($shop);
    }
}

<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CreatesShops;
use Tests\Traits\CreatesUsers;

class ShopTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;
    use CreatesShops;

    public function testAdminCanListUnacceptedShops(): void
    {
        $user = $this->createUser();

        $this->createShops(11, [
            "accepted" => false,
        ]);

        $this->createShops(12, [
            "accepted" => true,
        ]);

        $this->actingAs($user)
            ->get("admin/shops")
            ->assertSuccessful()
            ->assertJsonCount(11, "data");
    }

    public function testAdminCanSeeUnnaceptedShop(): void
    {
        $user = $this->createUser();
        $shop = $this->createShop([
            "accepted" => false,
        ]);

        $this->actingAs($user)
            ->get("/admin/shops/{$shop->id}")
            ->assertSuccessful()
            ->assertJsonFragment([
                "id" => $shop->id,
            ]);
    }

    public function testAdminCanAcceptShop(): void
    {
        $user = $this->createUser();
        $shop = $this->createShop([
            "accepted" => false,
        ]);

        $this->assertDatabaseHas("shops", [
            "id" => $shop->id,
            "accepted" => false,
        ]);

        $this->actingAs($user)
            ->post("/admin/shops/{$shop->id}/accept")
            ->assertSuccessful();

        $this->assertDatabaseHas("shops", [
            "id" => $shop->id,
            "accepted" => true,
        ]);
    }
}

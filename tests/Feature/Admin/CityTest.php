<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CreatesCities;
use Tests\Traits\CreatesUsers;

class CityTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;
    use CreatesCities;

    public function testAdminCanListCities(): void
    {
        $user = $this->createUser();
        $this->createCites(10);

        $this->actingAs($user)
            ->get("admin/cities")
            ->assertSuccessful()
            ->assertJsonCount(10, "data");
    }

    public function testAdminCanSeeCity(): void
    {
        $user = $this->createUser();
        $city = $this->createCity();

        $this->actingAs($user)
            ->get("/admin/cities/{$city->id}")
            ->assertSuccessful()
            ->assertJsonFragment([
                "id" => $city->id,
            ]);
    }

    public function testAdminCanCreateCity(): void
    {
        $user = $this->createUser();

        $this->actingAs($user)
            ->post("/admin/cities", [
                "name" => "Warsaw",
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas("cities", [
            "name" => "Warsaw",
            "slug" => "warsaw",
        ]);
    }

    public function testAdminCanUpdateCity(): void
    {
        $user = $this->createUser();
        $city = $this->createCity([]);

        $this->actingAs($user)
            ->put("/admin/cities/{$city->id}", [
                "name" => "lorem ipsum",
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas("cities", [
            "id" => $city->id,
            "name" => "lorem ipsum",
            "slug" => "lorem-ipsum",
        ]);
    }

    public function testAdminCanDeleteCity(): void
    {
        $user = $this->createUser();
        $city = $this->createCity();

        $this->assertModelExists($city);

        $this->actingAs($user)
            ->delete("/admin/cities/{$city->id}")
            ->assertSuccessful();

        $this->assertDeleted($city);
    }
}

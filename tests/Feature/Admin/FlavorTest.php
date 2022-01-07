<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CreatesFlavors;
use Tests\Traits\CreatesUsers;

class FlavorTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;
    use CreatesFlavors;

    public function testAdminCanListFlavors(): void
    {
        $user = $this->createAdmin();
        $this->createFlavors(10);

        $this->actingAs($user)
            ->get("admin/flavors")
            ->assertSuccessful()
            ->assertJsonCount(10, "data");
    }

    public function testAdminCanSeeFlavor(): void
    {
        $user = $this->createAdmin();
        $flavor = $this->createFlavor();

        $this->actingAs($user)
            ->get("/admin/flavors/{$flavor->id}")
            ->assertSuccessful()
            ->assertJsonFragment([
                "id" => $flavor->id,
            ]);
    }

    public function testAdminCanCreateFlavor(): void
    {
        $user = $this->createAdmin();

        $this->actingAs($user)
            ->post("/admin/flavors", [
                "name" => "lorem ipsum",
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas("flavors", [
            "name" => "lorem ipsum",
        ]);
    }

    public function testAdminCanUpdateFlavor(): void
    {
        $user = $this->createAdmin();
        $flavor = $this->createFlavor();

        $this->actingAs($user)
            ->put("/admin/flavors/{$flavor->id}", [
                "name" => "new flavor",
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas("flavors", [
            "id" => $flavor->id,
            "name" => "new flavor",
        ]);
    }

    public function testAdminCanDeleteFlavor(): void
    {
        $user = $this->createAdmin();
        $flavor = $this->createFlavor();

        $this->assertModelExists($flavor);

        $this->actingAs($user)
            ->delete("/admin/flavors/{$flavor->id}")
            ->assertSuccessful();

        $this->assertDeleted($flavor);
    }
}

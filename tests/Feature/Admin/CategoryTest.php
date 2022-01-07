<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CreatesCategories;
use Tests\Traits\CreatesUsers;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;
    use CreatesCategories;

    public function testAdminCanListCategories(): void
    {
        $user = $this->createAdmin();
        $this->createCategories(10);

        $this->actingAs($user)
            ->get("admin/categories")
            ->assertSuccessful()
            ->assertJsonCount(10, "data");
    }

    public function testAdminCanSeeCategory(): void
    {
        $user = $this->createAdmin();
        $category = $this->createCategory();

        $this->actingAs($user)
            ->get("/admin/categories/{$category->id}")
            ->assertSuccessful()
            ->assertJsonFragment([
                "id" => $category->id,
            ]);
    }

    public function testAdminCanCreateCategory(): void
    {
        $user = $this->createAdmin();

        $this->actingAs($user)
            ->post("/admin/categories", [
                "name" => "lorem ipsum",
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas("categories", [
            "name" => "lorem ipsum",
        ]);
    }

    public function testAdminCanUpdateCategory(): void
    {
        $user = $this->createAdmin();
        $category = $this->createCategory();

        $this->actingAs($user)
            ->put("/admin/categories/{$category->id}", [
                "name" => "new category",
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas("categories", [
            "id" => $category->id,
            "name" => "new category",
        ]);
    }

    public function testAdminCanDeleteCategory(): void
    {
        $user = $this->createAdmin();
        $category = $this->createCategory();

        $this->assertModelExists($category);

        $this->actingAs($user)
            ->delete("/admin/categories/{$category->id}")
            ->assertSuccessful();

        $this->assertDeleted($category);
    }
}

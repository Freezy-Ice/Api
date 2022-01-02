<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CreatesCategories;
use Tests\Traits\CreatesCities;
use Tests\Traits\CreatesFlavors;
use Tests\Traits\CreatesUsers;

class DictionaryTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;
    use CreatesCategories;
    use CreatesFlavors;
    use CreatesCities;

    public function testUserCanListAllCategories(): void
    {
        $user = $this->createUser();
        $this->createCategories(50);

        $this->actingAs($user)
            ->get("categories")
            ->assertSuccessful()
            ->assertJsonCount(50, "data");
    }

    public function testUserCanListAllCities(): void
    {
        $user = $this->createUser();
        $this->createCites(40);

        $this->actingAs($user)
            ->get("cities")
            ->assertSuccessful()
            ->assertJsonCount(40, "data");
    }

    public function testUserCanListAllFlavors(): void
    {
        $user = $this->createUser();
        $this->createFlavors(30);

        $this->actingAs($user)
            ->get("flavors")
            ->assertSuccessful()
            ->assertJsonCount(30, "data");
    }
}

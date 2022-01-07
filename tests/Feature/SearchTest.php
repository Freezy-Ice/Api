<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Category;
use App\Models\City;
use App\Models\Flavor;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CreatesCategories;
use Tests\Traits\CreatesCities;
use Tests\Traits\CreatesFlavors;
use Tests\Traits\CreatesProducts;
use Tests\Traits\CreatesShops;
use Tests\Traits\CreatesUsers;
use Tests\Traits\ManagesFavorites;

class SearchTest extends TestCase
{
    use RefreshDatabase;
    use CreatesCities;
    use CreatesCategories;
    use CreatesFlavors;
    use ManagesFavorites;
    use CreatesUsers;
    use CreatesShops;
    use CreatesProducts;

    protected User $user;

    protected City $cityA;
    protected City $cityB;

    protected Category $categoryA;
    protected Category $categoryB;

    protected Flavor $flavorA;
    protected Flavor $flavorB;
    protected Flavor $flavorC;

    protected Shop $shopA;
    protected Shop $shopB;
    protected Shop $shopC;
    protected Shop $shopD;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();

        $this->cityA = $this->createCity([
            "name" => "Legnica",
        ]);
        $this->cityB = $this->createCity([
            "name" => "Wrocław",
        ]);

        $this->categoryA = $this->createCategory([
            "name" => "Lody włoskie",
        ]);
        $this->categoryB = $this->createCategory([
            "name" => "Lody amerykańskie",
        ]);

        $this->flavorA = $this->createFlavor([
            "name" => "truskawkowy",
        ]);
        $this->flavorB = $this->createFlavor([
            "name" => "czekoladowy",
        ]);
        $this->flavorC = $this->createFlavor([
            "name" => "śmietankowy",
        ]);

        $this->shopA = $this->createShop([
            "city_id" => $this->cityA->id,
            "name" => "Lodziarnia A",
        ]);

        $this->createConcreteProductFor($this->shopA, $this->categoryA, $this->flavorA);
        $this->createConcreteProductFor($this->shopA, $this->categoryA, $this->flavorB);

        $this->shopB = $this->createShop([
            "city_id" => $this->cityA->id,
            "name" => "Lodziarnia B",
        ]);

        $this->createConcreteProductFor($this->shopB, $this->categoryA, $this->flavorA);

        $this->shopC = $this->createShop([
            "city_id" => $this->cityA->id,
            "name" => "Lodziarnia C",
        ]);

        $this->createConcreteProductFor($this->shopC, $this->categoryB, $this->flavorB);
        $this->createConcreteProductFor($this->shopC, $this->categoryB, $this->flavorC);

        $this->shopD = $this->createShop([
            "city_id" => $this->cityB->id,
            "name" => "Lodziarnia D",
        ]);

        $this->createConcreteProductFor($this->shopD, $this->categoryB, $this->flavorB);

        $this->likeShop($this->user, $this->shopA);
    }

    public function testUserCanSearchShopsByCity(): void
    {
        $this->actingAs($this->user)
            ->call("GET", "shops", [
                "city" => $this->cityB->id,
            ])
            ->assertSuccessful()
            ->assertJsonCount(1, "data");
    }

    public function testUserCanSearchByName(): void
    {
        $this->actingAs($this->user)
            ->call("GET", "shops", [
                "search" => "Lodziarnia",
            ])
            ->assertSuccessful()
            ->assertJsonCount(4, "data");
    }

    public function testUserCanSearchByProductCategory(): void
    {
        $this->actingAs($this->user)
            ->call("GET", "shops", [
                "category" => $this->categoryA->id,
            ])
            ->assertSuccessful()
            ->assertJsonCount(2, "data");
    }

    public function testUserCanSearchByProductFlavors(): void
    {
        $this->actingAs($this->user)
            ->call("GET", "shops", [
                "flavor" => [$this->flavorA->id, $this->flavorC->id],
            ])
            ->assertSuccessful()
            ->assertJsonCount(3, "data");
    }

    public function testUserCanSearchByFavorites(): void
    {
        $this->actingAs($this->user)
            ->call("GET", "shops", [
                "favorite" => 1,
            ])
            ->assertSuccessful()
            ->assertJsonCount(1, "data");
    }

    public function testUserCanCombineFiltersA(): void
    {
        $this->actingAs($this->user)
            ->call("GET", "shops", [
                "city" => $this->cityB->id,
                "flavor" => $this->flavorC->id,
            ])
            ->assertSuccessful()
            ->assertJsonCount(0, "data");
    }

    public function testUserCanCombineFiltersB(): void
    {
        $this->actingAs($this->user)
            ->call("GET", "shops", [
                "category" => $this->categoryA->id,
                "flavor" => $this->flavorB->id,
            ])
            ->assertSuccessful()
            ->assertJsonCount(1, "data");
    }

    public function testUserCanCombineFiltersC(): void
    {
        $this->actingAs($this->user)
            ->call("GET", "shops", [
                "city" => $this->cityA->id,
                "category" => $this->categoryA->id,
                "favorite" => 1,
            ])
            ->assertSuccessful()
            ->assertJsonCount(1, "data");
    }
}

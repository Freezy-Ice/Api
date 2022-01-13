<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CreatesCategories;
use Tests\Traits\CreatesFlavors;
use Tests\Traits\CreatesImages;
use Tests\Traits\CreatesProducts;
use Tests\Traits\CreatesShops;
use Tests\Traits\CreatesUsers;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;
    use CreatesShops;
    use CreatesCategories;
    use CreatesProducts;
    use CreatesFlavors;
    use CreatesImages;

    public function testUserCanSeeProductsOfShop(): void
    {
        $user = $this->createUser();
        $shop = $this->createShop();
        $this->createCategory();
        $this->createFlavor();
        $this->createProductsFor($shop, 3);
        $this->createProducts(10);

        $this->actingAs($user)
            ->get("/shops/{$shop->id}/products")
            ->assertSuccessful()
            ->assertJsonCount(3, "data");
    }

    public function testUserCanCreateProductForShop(): void
    {
        $user = $this->createCompanyUser();
        $shop = $this->createShopFor($user);
        $category = $this->createCategory();
        $flavor = $this->createFlavor();
        $image = $this->createImage();

        $this->actingAs($user)
            ->post("/business/shops/{$shop->id}/products", [
                "name" => "Product name",
                "image" => $image->id,
                "description" => "Description",
                "category" => $category->id,
                "flavors" => [
                    $flavor->id,
                ],
                "kcal" => "123",
                "price" => "123",
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas("products", [
            "shop_id" => $shop->id,
            "name" => "Product name",
            "description" => "Description",
            "category_id" => $category->id,
            "kcal" => "123",
            "price" => "123",
        ]);

        $this->assertDatabaseHas("flavor_product", [
            "flavor_id" => $flavor->id,
            "product_id" => 1,
        ]);
    }

    public function testUserCanSeeProduct(): void
    {
        $user = $this->createUser();
        $this->createCategory();
        $this->createFlavor();
        $shop = $this->createShop();
        $product = $this->createProduct();

        $this->actingAs($user)
            ->get("/shops/{$shop->id}/products/{$product->id}")
            ->assertSuccessful()
            ->assertJsonFragment([
                "id" => $product->id,
            ]);
    }

    public function testUserCanUpdateProduct(): void
    {
        $user = $this->createCompanyUser();
        $shop = $this->createShopFor($user);
        $this->createCategory();
        $this->createFlavor();
        $product = $this->createProductFor($shop);
        $category = $this->createCategory();
        $flavor = $this->createFlavor();
        $image = $this->createImage();

        $this->actingAs($user)
            ->put("/business/shops/{$shop->id}/products/{$product->id}", [
                "name" => "Product name",
                "image" => $image->id,
                "description" => "Description",
                "category" => $category->id,
                "flavors" => [
                    $flavor->id,
                ],
                "kcal" => "123",
                "price" => "123",
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas("products", [
            "shop_id" => $shop->id,
            "name" => "Product name",
            "description" => "Description",
            "category_id" => $category->id,
            "kcal" => "123",
            "price" => "123",
        ]);

        $this->assertDatabaseHas("flavor_product", [
            "flavor_id" => $flavor->id,
            "product_id" => $product->id,
        ]);
    }

    public function testUserCanDeleteProduct(): void
    {
        $user = $this->createCompanyUser();
        $shop = $this->createShopFor($user);
        $this->createCategory();
        $this->createFlavor();
        $product = $this->createProductFor($shop);

        $this->assertModelExists($product);

        $this->actingAs($user)
            ->delete("/business/shops/{$shop->id}/products/{$product->id}")
            ->assertSuccessful();

        $this->assertDeleted($product);
    }
}

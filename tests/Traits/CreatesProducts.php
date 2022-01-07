<?php

declare(strict_types=1);

namespace Tests\Traits;

use App\Models\Category;
use App\Models\Flavor;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Support\Collection;

trait CreatesProducts
{
    public function createProduct(array $data = []): Product
    {
        /** @var Product $product */
        $product = Product::factory($data)
            ->create();

        return $product;
    }

    public function createProductFor(Shop $shop, array $data = []): Product
    {
        /** @var Product $product */
        $product = Product::factory($data)
            ->for($shop)
            ->create();

        return $product;
    }

    public function createProducts(int $count = 5, array $data = []): Collection
    {
        return Product::factory($data)
            ->count($count)
            ->create();
    }

    public function createProductsFor(Shop $shop, int $count = 5, array $data = []): Collection
    {
        return Product::factory($data)
            ->count($count)
            ->for($shop)
            ->create();
    }

    public function createConcreteProductFor(Shop $shop, Category $category, Collection|Flavor $flavors): Product
    {
        /** @var Product $product */
        $product = Product::factory()
            ->for($shop)
            ->for($category)
            ->create();

        $product->flavors()->sync($flavors);

        return $product;
    }
}

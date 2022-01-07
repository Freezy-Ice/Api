<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use App\Models\Flavor;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            "name" => $this->faker->word(),
            "description" => $this->faker->paragraph(),
            "category_id" => Category::query()->inRandomOrder()->first()->id,
            "kcal" => $this->faker->numberBetween(300, 1200),
            "price" => $this->faker->numberBetween(1000, 10000),
        ];
    }

    public function configure(): Factory
    {
        return $this->afterCreating(function (Product $product): void {
            $product->flavors()->attach(Flavor::query()->inRandomOrder()->first()->id);
        });
    }

    public function forRandomShop(): Factory
    {
        return $this->state(
            fn() => [
                "shop_id" => Shop::query()->inRandomOrder()->first()->id,
            ],
        );
    }
}

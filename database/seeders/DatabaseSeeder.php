<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(CitySeeder::class);

        User::factory()
            ->count(50)
            ->create();

        Category::factory()
            ->count(10)
            ->create();

        Shop::factory()
            ->count(10)
            ->forRandomCity()
            ->forRandomUser()
            ->hasProducts(Product::factory()->count(10)->hasFlavors(2))
            ->create();
    }
}

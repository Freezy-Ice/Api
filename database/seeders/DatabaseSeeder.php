<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Flavor;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->count(10)
            ->hasIceCreamShops(1)
            ->create();

        Category::factory()
            ->count(10)
            ->create();

        Product::factory()
            ->count(20)
            ->forRandomIceCreamShop()
            ->has(Flavor::factory()->count(2))
            ->create();
    }
}

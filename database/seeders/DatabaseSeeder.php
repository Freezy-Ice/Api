<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(CitySeeder::class);

        User::factory()
            ->count(10)
            ->companyAccount()
            ->create();

        User::factory()
            ->count(40)
            ->create();

        Category::factory()
            ->count(10)
            ->create();

        Shop::factory()
            ->count(10)
            ->forRandomCity()
            ->forRandomCompanyUser()
            ->hasProducts(Product::factory()->count(10)->hasFlavors(2))
            ->create();

        Review::factory()
            ->count(20)
            ->forRandomUser()
            ->foRandomShop()
            ->create();
    }
}

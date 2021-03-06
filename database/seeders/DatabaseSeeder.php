<?php

declare(strict_types=1);

namespace Database\Seeders;

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
        $this->call(CategorySeeder::class);
        $this->call(FlavorSeeder::class);

        User::factory([
            "email" => "admin@example.com",
        ])
            ->adminAccount()
            ->create();

        User::factory()
            ->count(10)
            ->companyAccount()
            ->create();

        User::factory()
            ->count(40)
            ->create();

        Shop::factory()
            ->count(10)
            ->forRandomCity()
            ->forRandomCompanyUser()
            ->hasImage()
            ->has(Product::factory()->count(10)->hasImage())
            ->create();

        Review::factory()
            ->count(20)
            ->forRandomUser()
            ->forRandomShop()
            ->create();
    }
}

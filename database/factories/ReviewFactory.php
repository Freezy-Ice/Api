<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            "rating" => $this->faker->randomElement([0, 0.5, 1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5]),
            "comment" => $this->faker->text(),
            "shop_id" => Shop::factory(),
            "user_id" => User::factory(),
        ];
    }

    public function forRandomUser(): Factory
    {
        return $this->state(
            fn() => [
                "user_id" => User::query()->inRandomOrder()->first()->id,
            ],
        );
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

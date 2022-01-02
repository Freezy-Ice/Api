<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShopFactory extends Factory
{
    public function definition(): array
    {
        return [
            "name" => $this->faker->company(),
            "city_id" => City::factory(),
            "user_id" => User::factory(),
            "address" => $this->faker->streetAddress(),
            "description" => $this->faker->paragraph(),
            "lat" => $this->faker->latitude(51.19, 51.22),
            "lng" => $this->faker->longitude(16.14, 16.2),
            "accepted" => $this->faker->boolean(),
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

    public function forRandomCity(): Factory
    {
        return $this->state(
            fn() => [
                "city_id" => City::query()->inRandomOrder()->first()->id,
            ],
        );
    }
}

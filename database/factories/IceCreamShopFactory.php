<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class IceCreamShopFactory extends Factory
{
    public function definition(): array
    {
        return [
            "name" => $this->faker->company(),
            "city" => $this->faker->city(),
            "address" => $this->faker->streetAddress(),
            "description" => $this->faker->paragraph(),   
            "lat" => $this->faker->latitude(51.19, 51.22),
            "lng" => $this->faker->longitude(16.14, 16.2),            
            "accepted" => $this->faker->boolean()
        ];
    }
}

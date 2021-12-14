<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OpeningHoursFactory extends Factory
{
    public function definition(): array
    {
        return [
            "day" => $this->faker->dayOfWeek(),
            "from" => $this->faker->dateTimeBetween('8:00', '12:00')->format('H:i'),
            "to" => $this->faker->dateTimeBetween('15:00', '16:00')->format('H:i'),
            "open" => $this->faker->boolean()
        ];
    }
}

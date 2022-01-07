<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            "name" => $this->faker->name(),
            "email" => $this->faker->unique()->safeEmail(),
            "password" => Hash::make("secret123"),
            "company_account" => false,
            "admin_account" => false,
        ];
    }

    public function companyAccount(): Factory
    {
        return $this->state(
            fn() => [
                "company_account" => true,
            ],
        );
    }

    public function adminAccount(): Factory
    {
        return $this->state(
            fn() => [
                "admin_account" => true,
            ],
        );
    }
}

<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $json = json_decode(File::get("database/data/cities.json"), true);

        foreach ($json as $item) {
            City::query()->create($item);
        }
    }
}

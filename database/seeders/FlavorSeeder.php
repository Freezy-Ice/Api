<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Flavor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class FlavorSeeder extends Seeder
{
    public function run(): void
    {
        $json = json_decode(File::get("database/data/flavors.json"), true);

        foreach ($json as $item) {
            Flavor::query()->create($item);
        }
    }
}

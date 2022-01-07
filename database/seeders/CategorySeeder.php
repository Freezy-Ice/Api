<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $json = json_decode(File::get("database/data/categories.json"), true);

        foreach ($json as $item) {
            Category::query()->create($item);
        }
    }
}

<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use function json_decode;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $json = json_decode(File::get("database/data/cities.json"), true);

        DB::table("cities")->insert($json);
    }
}

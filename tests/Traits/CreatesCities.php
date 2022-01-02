<?php

declare(strict_types=1);

namespace Tests\Traits;

use App\Models\City;
use Illuminate\Support\Collection;

trait CreatesCities
{
    public function createCity(array $data = []): City
    {
        /** @var City $city */
        $city = City::factory($data)->create();

        return $city;
    }

    public function createCites(int $count = 5, array $data = []): Collection
    {
        return City::factory($data)->count($count)->create();
    }
}

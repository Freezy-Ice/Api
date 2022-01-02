<?php

declare(strict_types=1);

namespace Tests\Traits;

use App\Models\Flavor;
use Illuminate\Support\Collection;

trait CreatesFlavors
{
    public function createFlavor(array $data = []): Flavor
    {
        /** @var Flavor $flavor */
        $flavor = Flavor::factory($data)->create();

        return $flavor;
    }

    public function createFlavors(int $count = 5, array $data = []): Collection
    {
        return Flavor::factory($data)->count($count)->create();
    }
}

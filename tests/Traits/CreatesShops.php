<?php

declare(strict_types=1);

namespace Tests\Traits;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Collection;

trait CreatesShops
{
    public function createShop(array $data = []): Shop
    {
        /** @var Shop $shop */
        $shop = Shop::factory($data)->create();

        return $shop;
    }

    public function createShopFor(User $owner, array $data = []): Shop
    {
        /** @var Shop $shop */
        $shop = Shop::factory($data)->forCompanyUser($owner)->create();

        return $shop;
    }

    public function createShops(int $count = 5, array $data = []): Collection
    {
        return Shop::factory($data)->count($count)->create();
    }

    public function createShopsFor(User $owner, int $count = 5, array $data = []): Collection
    {
        return Shop::factory($data)
            ->forCompanyUser($owner)
            ->count($count)
            ->create();
    }
}

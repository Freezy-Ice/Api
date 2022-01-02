<?php

declare(strict_types=1);

namespace Tests\Traits;

use App\Models\Shop;
use App\Models\User;

trait ManagesFavorites
{
    public function likeShop(User $user, Shop $shop): void
    {
        $user->favoriteShops()->attach($shop);
    }

    public function dislikeShop(User $user, Shop $shop): void
    {
        $user->favoriteShops()->detach($shop);
    }
}

<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShopPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isBusiness();
    }

    public function view(User $user, Shop $shop): bool
    {
        return $user->isBusiness() && $shop->owner()->is($user);
    }

    public function create(User $user): bool
    {
        return $user->isBusiness();
    }

    public function update(User $user, Shop $shop): bool
    {
        return $user->isBusiness() && $shop->owner()->is($user);
    }

    public function delete(User $user, Shop $shop): bool
    {
        return $user->isBusiness() && $shop->owner()->is($user);
    }

    public function manageProducts(User $user, Shop $shop): bool
    {
        return $user->isBusiness() && $shop->owner()->is($user);
    }
}

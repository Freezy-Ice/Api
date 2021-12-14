<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\IceCreamShop;

class IceCreamShopObserver
{
    public function created(IceCreamShop $iceCreamShop): void
    {
        $days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday','Thursday','Friday', 'Saturday');

        foreach ($days as $day) {
            $iceCreamShop->openingHours()->create([
                'day' => $day
            ]);
        }        
    }
}

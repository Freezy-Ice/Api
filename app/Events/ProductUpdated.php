<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Product;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductUpdated
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Product $product,
    ) {
    }
}

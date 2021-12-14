<?php

declare(strict_types=1);

namespace App\Http\Resources\IceCreamShop;

use App\Http\Resources\PaginatedCollection;

class IceCreamShopCollection extends PaginatedCollection
{
    public function toArray($request): array
    {
        return [
            "data" => $this->collection,
            "paginationData" => $this->paginationData(),
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Resources\Shop\Business;

use App\Http\Resources\PaginatedCollection;

class ShopCollection extends PaginatedCollection
{
    public function toArray($request): array
    {
        return [
            "data" => $this->collection,
            "paginationData" => $this->paginationData(),
        ];
    }
}

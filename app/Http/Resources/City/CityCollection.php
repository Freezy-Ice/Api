<?php

declare(strict_types=1);

namespace App\Http\Resources\City;

use App\Http\Resources\PaginatedCollection;

class CityCollection extends PaginatedCollection
{
    public function toArray($request): array
    {
        return [
            "data" => $this->collection,
            "paginationData" => $this->paginationData(),
        ];
    }
}

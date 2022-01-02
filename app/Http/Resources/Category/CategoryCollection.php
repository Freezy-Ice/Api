<?php

declare(strict_types=1);

namespace App\Http\Resources\Category;

use App\Http\Resources\PaginatedCollection;

class CategoryCollection extends PaginatedCollection
{
    public function toArray($request): array
    {
        return [
            "data" => $this->collection,
            "paginationData" => $this->paginationData(),
        ];
    }
}

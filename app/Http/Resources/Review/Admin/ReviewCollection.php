<?php

declare(strict_types=1);

namespace App\Http\Resources\Review\Admin;

use App\Http\Resources\PaginatedCollection;

class ReviewCollection extends PaginatedCollection
{
    public function toArray($request): array
    {
        return [
            "data" => $this->collection,
            "paginationData" => $this->paginationData(),
        ];
    }
}

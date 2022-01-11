<?php

declare(strict_types=1);

namespace App\Http\Resources\Review;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "rating" => $this->rating,
            "comment" => $this->comment,
        ];
    }
}

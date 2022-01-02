<?php

declare(strict_types=1);

namespace App\Http\Resources\Review;

use App\Http\Resources\Shop\Admin\ShopResource; // TODO user resource
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "rating" => $this->rating,
            "comment" => $this->comment,
            "shop" => new ShopResource($this->shop),
        ];
    }
}

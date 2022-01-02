<?php

declare(strict_types=1);

namespace App\Http\Resources\Review\Admin;

use App\Http\Resources\Shop\Admin\ShopResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "rating" => $this->rating,
            "comment" => $this->comment,
            "user" => new UserResource($this->user),
            "shop" => new ShopResource($this->shop),
        ];
    }
}

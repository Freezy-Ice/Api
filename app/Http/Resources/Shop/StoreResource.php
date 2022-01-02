<?php

declare(strict_types=1);

namespace App\Http\Resources\Shop;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "city" => $this->city,
            "address" => $this->address,
            "description" => $this->description,
            "accepted" => $this->accepted,
        ];
    }
}

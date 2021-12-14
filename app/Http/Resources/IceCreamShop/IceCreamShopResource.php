<?php

declare(strict_types=1);

namespace App\Http\Resources\IceCreamShop;

use App\Http\Resources\OpeningHoursResource;
use Illuminate\Http\Resources\Json\JsonResource;

class IceCreamShopResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "city" => $this->city,
            "address" => $this->address,
            "description" => $this->description,
            "coords" => [
                "lat" => $this->lat,
                "lng" => $this->lng,
            ],
            "openingHours" => OpeningHoursResource::collection($this->openingHours),
            "updatedAt" => $this->updated_at->format('Y-m-d H:i:s'),
            "accepted" => $this->accepted
        ];
    }
}
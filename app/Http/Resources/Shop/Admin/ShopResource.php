<?php

declare(strict_types=1);

namespace App\Http\Resources\Shop\Admin;

use App\Http\Resources\City\CityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "city" => new CityResource($this->city),
            "address" => $this->address,
            "description" => $this->description,
        ];
    }
}

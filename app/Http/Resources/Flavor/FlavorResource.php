<?php

declare(strict_types=1);

namespace App\Http\Resources\Flavor;

use Illuminate\Http\Resources\Json\JsonResource;

class FlavorResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
        ];
    }
}

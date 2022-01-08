<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "url" => route("image.download", $this),
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Requests\IceCreamShop;

use Illuminate\Foundation\Http\FormRequest;

class IceCreamShopRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => ["required"],
            "city" => ["required"],
            "address" => ["required"],
            "description" => ["required"],
            "coords.lat" => ["required", "numeric"],
            "coords.lng" => ["required", "numeric"],
            "openingHours" => ["required", "array"],
            "openingHours.*.day" => ["required"],
            "openingHours.*.from" => ["required"],
            "openingHours.*.to" => ["required"],
            "openingHours.*.open" => ["required", "boolean"],
        ];
    }

    public function getUpdateData(): array
    {
        return $this->only("name", "city", "address", "description");
    }

    public function getOpeningHours(): array
    {
        return $this->get("openingHours", []);
    }
}

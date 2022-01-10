<?php

declare(strict_types=1);

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => ["required", "min:3", "max:50"],
            "city" => ["required", "exists:cities,id"],
            "address" => ["required", "min:3", "max:50"],
            "description" => ["required", "min:3", "max:500"],
        ];
    }

    public function getStoreData(): array
    {
        return [
            "name" => $this->get("name"),
            "city_id" => $this->get("city"),
            "address" => $this->get("address"),
            "description" => $this->get("description"),
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Requests\IceCreamShop;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => ["required"],
            "city" => ["required"],
            "address" => ["required"],
            "description" => ["required"],
        ];
    }

    public function getStoreData(): array
    {
        return $this->only("name", "city", "address", "description");
    }
}

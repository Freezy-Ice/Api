<?php

declare(strict_types=1);

namespace App\Http\Requests\Shop;

use App\Enums\DayOfWeek;
use App\Models\Image;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => ["required", "min:3", "max:50"],
            "city" => ["required", "exists:cities,id"],
            "address" => ["required", "min:3", "max:50"],
            "description" => ["required", "min:3", "max:500"],
            "coords" => ["required", "array"],
            "coords.lat" => ["required", "numeric"],
            "coords.lng" => ["required", "numeric"],
            "openingHours" => ["required", "array"],
            "openingHours.*.day" => ["required", new Enum(DayOfWeek::class)],
            "openingHours.*.from" => ["required", "date_format:H:i"],
            "openingHours.*.to" => ["required", "date_format:H:i"],
            "openingHours.*.open" => ["required", "boolean"],
            "image" => ["nullable", "exists:images,id"],
        ];
    }

    public function getUpdateData(): array
    {
        return [
            "name" => $this->get("name"),
            "city_id" => $this->get("city"),
            "address" => $this->get("address"),
            "description" => $this->get("description"),
            "lat" => $this->input("coords.lat"),
            "lng" => $this->input("coords.lng"),
        ];
    }

    public function getOpeningHours(): array
    {
        return $this->get("openingHours");
    }

    public function getImage(): ?Image
    {
        /** @var Image $image */
        $image = Image::query()->find($this->get("image"));

        return $image;
    }
}

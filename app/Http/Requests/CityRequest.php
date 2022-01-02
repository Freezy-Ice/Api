<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CityRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => [
                "required",
                "min:3",
                "max:100",
                Rule::unique("cities", "name")->ignore($this->city),
            ],
        ];
    }

    public function getData(): array
    {
        $name = $this->get("name");

        return [
            "name" => $name,
            "slug" => Str::slug($name),
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => [
                "required",
                "min:3",
                "max:100",
                Rule::unique("categories", "name")->ignore($this->category),
            ],
        ];
    }

    public function getData(): array
    {
        return [
            "name" => $this->get("name"),
        ];
    }
}

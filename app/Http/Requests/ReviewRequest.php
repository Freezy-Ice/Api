<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReviewRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "comment" => [
                "nullable",
                "min:3",
                "max:1000",
            ],
            "rating" => [
                "required",
                Rule::in([0, 0.5, 1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5]),
            ],
        ];
    }

    public function getData(): array
    {
        return [
            "rating" => (float)$this->get("rating"),
            "comment" => $this->get("comment"),
            "user_id" => $this->user()->id,
        ];
    }
}

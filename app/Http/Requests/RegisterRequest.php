<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $email
 * @property string $name
 * @property string $password
 */
class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "email" => ["required", "email", "unique:users,email"],
            "name" => ["required", "min:5"],
            "password" => ["required", "confirmed"],
            "password_confirmation" => ["required"],
        ];
    }
}

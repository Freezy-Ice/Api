<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "email" => ["required", "email", "unique:users,email"],
            "name" => ["required", "min:5"],
            "companyAccount" => ["required", "boolean"],
            "password" => ["required", "same:passwordConfirmation"],
            "passwordConfirmation" => ["required"],
        ];
    }

    public function getData(): array
    {
        return [
            "name" => $this->get("name"),
            "email" => $this->get("email"),
            "password" => Hash::make($this->get("password")),
            "company_account" => $this->boolean("companyAccount"),
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __invoke(Request $request): array
    {
        return [
            "data" => new UserResource($request->user()),
        ];
    }
}

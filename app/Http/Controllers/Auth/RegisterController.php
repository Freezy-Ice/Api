<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::query()->create($request->getData());

        return response()->json([
            "data" => $user->createToken($user->email)->plainTextToken,
        ]);
    }
}

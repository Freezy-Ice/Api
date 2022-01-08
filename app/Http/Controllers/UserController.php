<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    public function user(Request $request): JsonResource
    {
        return new UserResource($request->user());
    }

    public function enableNotifications(Request $request): JsonResource
    {
        $user = $request->user();

        $user->enableNotifications();

        return new UserResource($user);
    }

    public function disableNotifications(Request $request): JsonResource
    {
        $user = $request->user();

        $user->disableNotifications();

        return new UserResource($user);
    }
}

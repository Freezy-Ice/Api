<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get("/", fn(): array => [
    "success" => true,
]);

Route::prefix("auth")->group(function (): void {
    Route::post("login", LoginController::class);
    Route::post("register", RegisterController::class);

    Route::middleware("auth:sanctum")->group(function (): void {
        Route::get("user", UserController::class);
        Route::post("logout", LogoutController::class);
    });
});

Route::middleware("auth:sanctum")->group(function (): void {
    Route::prefix("business")->group(function (): void {
        Route::get("/shops", [ShopController::class, "index"]);
        Route::post("/shops", [ShopController::class, "store"]);
        Route::get("/shops/{shop}", [ShopController::class, "show"]);
        Route::put("/shops/{shop}", [ShopController::class, "update"]);
        Route::delete("/shops/{shop}", [ShopController::class, "delete"]);

        Route::post("/shops/{shop}/products", [ProductController::class, "store"]);
        Route::put("/products/{product}", [ProductController::class, "update"]);
        Route::delete("/products/{product}", [ProductController::class, "delete"]);
    });
    Route::get("/shops/{shop}/products", [ProductController::class, "index"]);
    Route::get("/products/{product}", [ProductController::class, "show"]);
});

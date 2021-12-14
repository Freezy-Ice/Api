<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\IceCreamShopController;
use App\Http\Controllers\ProductController;
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
    Route::get("/business/ice-cream-shops", [IceCreamShopController::class, "index"]);
    Route::post("/business/ice-cream-shops", [IceCreamShopController::class, "store"]);
    Route::get("/business/ice-cream-shops/{iceCreamShop}", [IceCreamShopController::class, "show"]);
    Route::put("/business/ice-cream-shops/{iceCreamShop}", [IceCreamShopController::class, "update"]);
    Route::delete("/business/ice-cream-shops/{iceCreamShop}", [IceCreamShopController::class, "delete"]);

    Route::get("/ice-cream-shops/{iceCreamShop}/products", [ProductController::class, "index"]);
    Route::post("/business/ice-cream-shops/{iceCreamShop}/products", [ProductController::class, "store"]);
    Route::get("/ice-cream-shops/{iceCreamShop}/products/{product}", [ProductController::class, "show"]);
    Route::put("/business/ice-cream-shops/{iceCreamShop}/products/{product}", [ProductController::class, "update"]);
    Route::delete("/business/ice-cream-shops/{iceCreamShop}/products/{product}", [ProductController::class, "delete"]);
});

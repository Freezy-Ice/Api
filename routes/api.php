<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\FlavorController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\ShopController as AdminShopController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Business\ProductController as BusinessProductController;
use App\Http\Controllers\Business\ShopController as BusinessShopController;
use App\Http\Controllers\DictionaryController;
use App\Http\Controllers\FavoriteShopController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ShopController;

use Illuminate\Support\Facades\Route;

Route::get("/", fn(): array => [
    "success" => true,
]);

Route::prefix("auth")->group(function (): void {
    Route::post("login", LoginController::class);
    Route::post("register", RegisterController::class);
    Route::post("logout", LogoutController::class)->middleware("auth:sanctum");
});

Route::middleware("auth:sanctum")->scopeBindings()->group(function (): void {
    Route::prefix("me")->group(function (): void {
        Route::get("/", UserController::class);
        Route::get("/favorites", [FavoriteShopController::class, "index"]);
        Route::get("/reviews", [ReviewController::class, "index"]);
    });

    Route::prefix("admin")->middleware("can:is-admin")->group(function (): void {
        Route::get("shops", [AdminShopController::class, "index"]);
        Route::get("shops/{shop}", [AdminShopController::class, "show"]);
        Route::post("shops/{shop}/accept", [AdminShopController::class, "accept"]);

        Route::get("reviews", [AdminReviewController::class, "index"]);
        Route::delete("reviews/{review}", [AdminReviewController::class, "destroy"]);

        Route::apiResource("flavors", FlavorController::class);
        Route::apiResource("categories", CategoryController::class);
        Route::apiResource("cities", CityController::class);
    });

    Route::prefix("business")->group(function (): void {
        Route::apiResource("shops", BusinessShopController::class);
        Route::apiResource("shops.products", BusinessProductController::class)
            ->middleware("can:manageProducts,shop");
    });

    Route::get("shops", [ShopController::class, "search"]);
    Route::get("shops/{shop}", [ShopController::class, "show"]);
    Route::get("shops/{shop}/products", [ProductController::class, "index"]);
    Route::get("shops/{shop}/products/{product}", [ProductController::class, "show"]);

    Route::post("shops/{shop}/like", [FavoriteShopController::class, "like"]);
    Route::delete("shops/{shop}/like", [FavoriteShopController::class, "dislike"]);
    Route::post("shops/{shop}/review", [ReviewController::class, "store"]);
    Route::delete("shops/{shop}/review", [ReviewController::class, "destroy"]);
});

Route::get("cities", [DictionaryController::class, "cities"]);
Route::get("flavors", [DictionaryController::class, "flavors"]);
Route::get("categories", [DictionaryController::class, "categories"]);

<?php

declare(strict_types=1);

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

Route::get("images/{image}", [ImageController::class, "download"])
    ->name("image.download");

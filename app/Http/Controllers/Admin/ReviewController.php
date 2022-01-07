<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Review\Admin\ReviewCollection;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class ReviewController extends Controller
{
    public function index(Request $request): JsonResource
    {
        $reviews = Review::query()
            ->with(["user", "shop"])
            ->paginate($request->query("perPage"));

        return new ReviewCollection($reviews);
    }

    public function destroy(Review $review): Response
    {
        $review->delete();

        return response()->noContent();
    }
}

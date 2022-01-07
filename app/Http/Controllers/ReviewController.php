<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Http\Resources\Review\ReviewCollection;
use App\Http\Resources\Review\ReviewResource;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class ReviewController extends Controller
{
    public function index(Request $request): JsonResource
    {
        $reviews = $request->user()
            ->reviews()
            ->with(["user", "shop"])
            ->paginate($request->query("perPage"));

        return new ReviewCollection($reviews);
    }

    public function store(ReviewRequest $request, Shop $shop): JsonResource
    {
        abort_if($shop->reviews->contains($request->user()), 403);

        $review = $shop->reviews()->create($request->getData());

        return new ReviewResource($review);
    }

    public function destroy(Request $request, Shop $shop): Response
    {
        $shop->reviews()->where("user_id", $request->user()->id)->delete();

        return response()->noContent();
    }
}

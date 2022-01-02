<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FlavorRequest;
use App\Http\Resources\Flavor\FlavorCollection;
use App\Http\Resources\Flavor\FlavorResource;
use App\Models\Flavor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class FlavorController extends Controller
{
    public function index(Request $request): JsonResource
    {
        $flavors = Flavor::query()->paginate($request->query("perPage"));

        return new FlavorCollection($flavors);
    }

    public function store(FlavorRequest $request): JsonResource
    {
        $flavor = Flavor::query()->create($request->getData());

        return new FlavorResource($flavor);
    }

    public function show(Flavor $flavor): JsonResource
    {
        return new FlavorResource($flavor);
    }

    public function update(FlavorRequest $request, Flavor $flavor): JsonResource
    {
        $flavor->update($request->getData());

        return new FlavorResource($flavor);
    }

    public function destroy(Flavor $flavor): Response
    {
        $flavor->delete();

        return response()->noContent();
    }
}

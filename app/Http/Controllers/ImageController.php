<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ImageController extends Controller
{
    public function download(Image $image): BinaryFileResponse
    {
        return response()->download(
            file: storage_path("app/{$image->path}"),
            disposition: ResponseHeaderBag::DISPOSITION_INLINE,
        );
    }

    public function store(ImageRequest $request): JsonResource
    {
        $image = Image::query()->create($request->getImageData());

        return new ImageResource($image);
    }
}

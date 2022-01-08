<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * @property UploadedFile $file
 */
class ImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "image" => ["required", "image", "max:8096"],
        ];
    }

    public function getImageData(): array
    {
        /** @var UploadedFile $file */
        $file = $this->file("image");
        $uuid = Str::uuid()->toString();

        return [
            "id" => $uuid,
            "path" => $file->storeAs("images/{$uuid}", $file->getClientOriginalName()),
        ];
    }
}

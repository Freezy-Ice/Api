<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageObserver
{
    public function creating(Image $image): void
    {
        if ($image->id === null) {
            $image->id = Str::uuid()->toString();
        }
    }

    public function deleted(Image $image): void
    {
        Storage::deleteDirectory("images/{$image->id}");
    }
}

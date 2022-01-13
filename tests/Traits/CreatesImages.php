<?php

declare(strict_types=1);

namespace Tests\Traits;

use App\Models\Image;

trait CreatesImages
{
    public function createImage(): Image
    {
        /** @var Image $image */
        $image = Image::factory()
            ->create();

        return $image;
    }
}

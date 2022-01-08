<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition(): array
    {
        $uuid = Str::uuid()->toString();
        $file = UploadedFile::fake()->image(Str::random(24) . ".png");

        return [
            "id" => $uuid,
            "path" => $file->storeAs("images/{$uuid}", $file->getClientOriginalName()),
        ];
    }

    public function forRandomUser(): Factory
    {
        return $this->state(
            fn() => [
                "user_id" => User::query()->inRandomOrder()->first()->id,
            ],
        );
    }
}

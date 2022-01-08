<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\Traits\CreatesUsers;

class ImageTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake();
    }

    public function testUserCanUploadImage(): void
    {
        $user = $this->createUser();

        $this->assertDatabaseCount("images", 0);

        $this->actingAs($user)
            ->post("/business/images", [
                "image" => UploadedFile::fake()->image("fake.png"),
            ])
            ->assertSuccessful();

        $this->assertDatabaseCount("images", 1);

        $image = Image::query()->first();

        Storage::assertExists("images/{$image->id}");
    }
}

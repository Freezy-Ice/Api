<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function testExample(): void
    {
        $response = $this->get("/api");

        $response->assertStatus(200);
    }
}

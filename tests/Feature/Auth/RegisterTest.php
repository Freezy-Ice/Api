<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tests\Traits\CreatesUsers;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;

    public function testUserCanRegisterWithProperCredentials(): void
    {
        $response = $this->post("auth/register", [
            "email" => "test@example.com",
            "name" => "Test user",
            "password" => "secret123",
            "passwordConfirmation" => "secret123",
            "companyAccount" => false,
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas("users", [
            "email" => "test@example.com",
            "name" => "Test user",
            "company_account" => false,
        ]);
    }

    public function testUserCanRegisterAsCompanyAccount(): void
    {
        $response = $this->post("auth/register", [
            "email" => "test@example.com",
            "name" => "Test user",
            "password" => "secret123",
            "passwordConfirmation" => "secret123",
            "companyAccount" => true,
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas("users", [
            "email" => "test@example.com",
            "name" => "Test user",
            "company_account" => true,
        ]);
    }

    public function testUserCannotRegisterWithoutNameProperty(): void
    {
        $response = $this->post("auth/register", [
            "email" => "test@example.com",
            "password" => "secret123",
            "passwordConfirmation" => "secret123",
            "companyAccount" => false,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors("name");
    }

    public function testUserCannotRegisterUsingExistingEmail(): void
    {
        $email = "test@example.com";

        $this->createUser($email);

        $response = $this->post("auth/register", [
            "email" => $email,
            "name" => "Test user",
            "password" => "secret123",
            "passwordConfirmation" => "secret123",
            "company_account" => false,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors("email");
    }

    public function testUserCannotRegisterWithoutPasswordConfirmation(): void
    {
        $response = $this->post("auth/register", [
            "email" => "test@example.com",
            "name" => "Test user",
            "password" => "secret123",
            "companyAccount" => false,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(["password", "passwordConfirmation"]);
    }
}

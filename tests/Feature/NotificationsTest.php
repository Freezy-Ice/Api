<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Events\ShopUpdated;
use App\Notifications\ShopUpdated as ShopUpdatedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Tests\Traits\CreatesShops;
use Tests\Traits\CreatesUsers;
use Tests\Traits\ManagesFavorites;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;
    use CreatesShops;
    use ManagesFavorites;

    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();
    }

    public function testUserCanEnableNotifications(): void
    {
        $user = $this->createUser();

        $this->actingAs($user)
            ->post("me/allow-notifications")
            ->assertSuccessful();

        $this->assertDatabaseHas("users", [
            "id" => $user->id,
            "allow_notifications" => true,
        ]);
    }

    public function testUserCanDisableNotifications(): void
    {
        $user = $this->createUser();

        $this->actingAs($user)
            ->delete("me/allow-notifications")
            ->assertSuccessful();

        $this->assertDatabaseHas("users", [
            "id" => $user->id,
            "allow_notifications" => false,
        ]);
    }

    public function testUserIsNotifiedIfLikedShop(): void
    {
        $user = $this->createUser();
        $shop = $this->createShop();
        $this->likeShop($user, $shop);

        event(new ShopUpdated($shop));

        Notification::assertSentTo($user, ShopUpdatedNotification::class);
    }

    public function testUserIsNotifiedIfDidntLikeShop(): void
    {
        $user = $this->createUser();
        $shop = $this->createShop();

        event(new ShopUpdated($shop));

        Notification::assertNotSentTo($user, ShopUpdatedNotification::class);
    }

    public function testUserIsNotifiedIfDidntLikeShopEvenIfEnabledNotifications(): void
    {
        $user = $this->createUser();
        $shop = $this->createShop();

        $user->enableNotifications();
        $user->save();

        event(new ShopUpdated($shop));

        Notification::assertNotSentTo($user, ShopUpdatedNotification::class);
    }

    public function testUserIsNotNotifiedIfLikedShopButDisabledNotifications(): void
    {
        $user = $this->createUser();
        $shop = $this->createShop();
        $this->likeShop($user, $shop);

        $user->disableNotifications();
        $user->save();

        event(new ShopUpdated($shop));

        Notification::assertNotSentTo($user, ShopUpdatedNotification::class);
    }
}

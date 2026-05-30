<?php

namespace Tests\Feature\AdminLte;

use App\Models\User;
use App\Notifications\AdminLteDemoNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_the_notifications_index(): void
    {
        $this->get(route('adminlte.notifications.index'))
            ->assertRedirect(route('login'));
    }

    public function test_an_authenticated_user_can_view_their_notifications(): void
    {
        $user = User::factory()->create();
        $user->notify(new AdminLteDemoNotification('Hello', 'A test notification.'));

        $this->actingAs($user)
            ->get(route('adminlte.notifications.index'))
            ->assertOk()
            ->assertSee('A test notification.');
    }

    public function test_a_user_can_mark_all_notifications_as_read(): void
    {
        $user = User::factory()->create();
        $user->notify(new AdminLteDemoNotification('Hello', 'A test notification.'));

        $this->assertSame(1, $user->unreadNotifications()->count());

        $this->actingAs($user)
            ->put(route('adminlte.notifications.read-all'))
            ->assertRedirect(route('adminlte.notifications.index'));

        $this->assertSame(0, $user->fresh()->unreadNotifications()->count());
    }

    public function test_a_user_can_delete_a_notification(): void
    {
        $user = User::factory()->create();
        $user->notify(new AdminLteDemoNotification('Hello', 'A test notification.'));
        $id = $user->notifications()->first()->id;

        $this->actingAs($user)
            ->delete(route('adminlte.notifications.destroy', $id))
            ->assertRedirect(route('adminlte.notifications.index'));

        $this->assertSame(0, $user->fresh()->notifications()->count());
    }
}

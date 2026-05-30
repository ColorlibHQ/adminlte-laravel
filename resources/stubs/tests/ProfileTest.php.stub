<?php

namespace Tests\Feature\AdminLte;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_the_profile_page(): void
    {
        $this->get(route('adminlte.profile.show'))
            ->assertRedirect(route('login'));
    }

    public function test_a_user_can_view_their_profile(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('adminlte.profile.show'))
            ->assertOk();
    }

    public function test_a_user_can_update_their_profile(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put(route('adminlte.profile.update'), [
                'name' => 'Updated Name',
                'email' => 'updated@example.com',
            ])
            ->assertRedirect(route('adminlte.profile.show'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }

    public function test_a_user_can_change_their_password(): void
    {
        $user = User::factory()->create(['password' => Hash::make('old-password')]);

        $this->actingAs($user)
            ->put(route('adminlte.profile.password.update'), [
                'current_password' => 'old-password',
                'password' => 'new-password-123',
                'password_confirmation' => 'new-password-123',
            ])
            ->assertRedirect(route('adminlte.profile.show'));

        $this->assertTrue(Hash::check('new-password-123', $user->fresh()->password));
    }

    public function test_password_change_requires_the_correct_current_password(): void
    {
        $user = User::factory()->create(['password' => Hash::make('old-password')]);

        $this->actingAs($user)
            ->put(route('adminlte.profile.password.update'), [
                'current_password' => 'wrong-password',
                'password' => 'new-password-123',
                'password_confirmation' => 'new-password-123',
            ])
            ->assertSessionHasErrors('current_password');
    }

    public function test_a_user_can_delete_their_account(): void
    {
        $user = User::factory()->create(['password' => Hash::make('secret-password')]);

        $this->actingAs($user)
            ->delete(route('adminlte.profile.destroy'), ['password' => 'secret-password'])
            ->assertRedirect('/');

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}

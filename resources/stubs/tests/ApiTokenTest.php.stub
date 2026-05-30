<?php

namespace Tests\Feature\AdminLte;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Requires Laravel Sanctum (php artisan install:api) — the User model must use
 * the Laravel\Sanctum\HasApiTokens trait and the personal_access_tokens table
 * must exist.
 */
class ApiTokenTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_the_tokens_page(): void
    {
        $this->get(route('adminlte.api-tokens.index'))
            ->assertRedirect(route('login'));
    }

    public function test_a_user_can_view_their_tokens(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('adminlte.api-tokens.index'))
            ->assertOk();
    }

    public function test_a_user_can_create_and_revoke_a_token(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('adminlte.api-tokens.store'), ['name' => 'CI deploy'])
            ->assertRedirect(route('adminlte.api-tokens.index'))
            ->assertSessionHas('token_plain');

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'name' => 'CI deploy',
        ]);

        $tokenId = $user->tokens()->first()->id;

        $this->actingAs($user)
            ->delete(route('adminlte.api-tokens.destroy', $tokenId))
            ->assertRedirect(route('adminlte.api-tokens.index'));

        $this->assertSame(0, $user->fresh()->tokens()->count());
    }
}

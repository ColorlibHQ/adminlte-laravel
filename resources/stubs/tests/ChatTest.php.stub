<?php

namespace Tests\Feature\AdminLte;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_the_chat_index(): void
    {
        $this->get(route('adminlte.chat.index'))
            ->assertRedirect(route('login'));
    }

    public function test_an_authenticated_user_can_view_the_chat_index(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('adminlte.chat.index'))
            ->assertOk();
    }

    public function test_posting_a_message_stores_it(): void
    {
        $user = User::factory()->create();
        $conversation = Conversation::factory()->create();
        $conversation->users()->attach($user);

        $this->actingAs($user)
            ->post(route('adminlte.chat.store', $conversation), [
                'body' => 'Hey, how is it going?',
            ])
            ->assertRedirect(route('adminlte.chat.show', $conversation));

        $this->assertDatabaseHas('adminlte_chat_messages', [
            'conversation_id' => $conversation->id,
            'user_id' => $user->id,
            'body' => 'Hey, how is it going?',
        ]);
    }
}

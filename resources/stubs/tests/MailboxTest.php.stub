<?php

namespace Tests\Feature\AdminLte;

use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MailboxTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_the_inbox(): void
    {
        $this->get(route('adminlte.mailbox.index'))
            ->assertRedirect(route('login'));
    }

    public function test_an_authenticated_user_can_view_the_inbox(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('adminlte.mailbox.index'))
            ->assertOk();
    }

    public function test_composing_a_message_stores_it(): void
    {
        $sender = User::factory()->create();
        $recipient = User::factory()->create();

        $this->actingAs($sender)
            ->post(route('adminlte.mailbox.store'), [
                'to_user_id' => $recipient->id,
                'subject' => 'Hello there',
                'body' => 'This is the body of the message.',
            ])
            ->assertRedirect(route('adminlte.mailbox.index'));

        $this->assertDatabaseHas('adminlte_messages', [
            'from_user_id' => $sender->id,
            'to_user_id' => $recipient->id,
            'subject' => 'Hello there',
        ]);
    }

    public function test_a_recipient_can_delete_a_message(): void
    {
        $user = User::factory()->create();
        $message = Message::factory()->create(['to_user_id' => $user->id]);

        $this->actingAs($user)
            ->delete(route('adminlte.mailbox.destroy', $message))
            ->assertRedirect(route('adminlte.mailbox.index'));

        $this->assertDatabaseMissing('adminlte_messages', [
            'id' => $message->id,
        ]);
    }
}

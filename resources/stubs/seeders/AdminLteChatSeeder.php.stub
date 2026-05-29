<?php

namespace Database\Seeders;

use App\Models\ChatMessage;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminLteChatSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->count() < 2) {
            $users = User::factory()->count(4)->create();
        }

        $me = $users->first();

        foreach ($users->skip(1)->take(3) as $partner) {
            $conversation = Conversation::create(['name' => null]);
            $conversation->users()->attach([$me->id, $partner->id]);

            foreach (range(1, fake()->numberBetween(3, 8)) as $i) {
                ChatMessage::create([
                    'conversation_id' => $conversation->id,
                    'user_id' => fake()->randomElement([$me->id, $partner->id]),
                    'body' => fake()->sentence(fake()->numberBetween(4, 12)),
                ]);
            }
        }
    }
}

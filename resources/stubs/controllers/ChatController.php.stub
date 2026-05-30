<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\AdminLte\StoreChatMessageRequest;
use App\Models\ChatMessage;
use App\Models\Conversation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    use AuthorizesRequests;

    public function index(?Conversation $conversation = null): View
    {
        $conversations = Conversation::with(['users', 'latestMessage'])
            ->whereHas('users', fn ($q) => $q->where('users.id', Auth::id()))
            ->get();

        $active = $conversation?->exists
            ? $conversation->load('messages.user')
            : $conversations->first()?->load('messages.user');

        return view('adminlte.chat.index', compact('conversations', 'active'));
    }

    public function store(StoreChatMessageRequest $request, Conversation $conversation): RedirectResponse
    {
        $this->authorize('view', $conversation);

        ChatMessage::create([
            'conversation_id' => $conversation->id,
            'user_id' => Auth::id(),
            'body' => $request->validated()['body'],
        ]);

        return redirect()->route('adminlte.chat.show', $conversation);
    }
}

<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\AdminLte\StoreMessageRequest;
use App\Models\Message;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class MailboxController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $this->authorize('viewAny', \App\Models\Message::class);

        $messages = Message::with('sender')
            ->where('to_user_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view('adminlte.mailbox.inbox', compact('messages'));
    }

    public function show(Message $message): View
    {
        $this->authorize('view', $message);

        if (! $message->is_read) {
            $message->update(['is_read' => true]);
        }

        $message->load('sender');

        return view('adminlte.mailbox.read', compact('message'));
    }

    public function create(): View
    {
        return view('adminlte.mailbox.compose');
    }

    public function store(StoreMessageRequest $request): RedirectResponse
    {
        $this->authorize('create', \App\Models\Message::class);

        $data = $request->validated();

        Message::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $data['to_user_id'],
            'subject' => $data['subject'],
            'body' => $data['body'],
        ]);

        return redirect()->route('adminlte.mailbox.index')
            ->with('status', __('adminlte.message_sent'));
    }

    public function destroy(Message $message): RedirectResponse
    {
        $this->authorize('delete', $message);

        $message->delete();

        return redirect()->route('adminlte.mailbox.index')
            ->with('status', __('adminlte.delete_message'));
    }
}

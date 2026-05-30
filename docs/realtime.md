# Real-time (Reverb / Echo)

Live chat messages and push notifications over WebSockets. This scaffold provides
the Laravel-side broadcast event, the channel authorization, and the Echo
listeners; the broadcaster itself (Laravel Reverb) is installed separately.

> Real-time needs a **running WebSocket server** (`reverb:start`). Unlike the
> other sections it isn't visible on a plain `php artisan serve` — it degrades
> gracefully: with no broadcaster configured, the event simply doesn't broadcast
> and the app works normally.

## Scaffold

```bash
php artisan adminlte:scaffold realtime
```

Publishes:

| Artifact | Destination |
|----------|-------------|
| `NewChatMessage` broadcast event | `app/Events/` |
| Echo listener bundle | `resources/js/adminlte-realtime.js` |
| Conversation channel authorization | appended to `routes/channels.php` (when present) |

## Going live

1. **Install broadcasting** (choose **Reverb**) and set the `REVERB_*` keys in `.env`:

   ```bash
   php artisan install:broadcasting
   ```

2. **Build the client** (laravel-echo + the Reverb client are added by the step above):

   ```bash
   npm install && npm run build
   ```

3. **Import the listeners** from your Vite entry (after Echo is bootstrapped):

   ```js
   // resources/js/app.js
   import './adminlte-realtime'
   ```

4. **Broadcast on send** — in `ChatController@store`, after persisting the message:

   ```php
   broadcast(new \App\Events\NewChatMessage($message))->toOthers();
   ```

5. **Run the servers:**

   ```bash
   php artisan reverb:start
   php artisan queue:work     # if the event implements ShouldBroadcast (queued)
   ```

## How it works

- `NewChatMessage` broadcasts on the **private** channel `conversation.{id}` with a
  small payload (`id`, `body`, `user_id`, `created_at`).
- `routes/channels.php` authorizes a user on that channel only if they belong to
  the conversation.
- `adminlte-realtime.js` subscribes the open conversation and dispatches a DOM
  `adminlte:chat-message` event your chat view can render; it also listens on
  Laravel's `App.Models.User.{id}` channel for broadcast **notifications** and
  dispatches `adminlte:notification`.

All of it no-ops when `window.Echo` is absent, so the bundle is safe to ship even
before you finish the Reverb setup.

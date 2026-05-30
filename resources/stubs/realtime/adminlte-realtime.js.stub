/**
 * AdminLTE real-time helpers (Laravel Echo + Reverb).
 *
 * Prerequisite: `php artisan install:broadcasting` (sets up Echo + a broadcaster)
 * and a running Reverb server (`php artisan reverb:start`). Import this file from
 * your Vite entry (resources/js/app.js) AFTER Echo is bootstrapped:
 *
 *     import './adminlte-realtime'
 *
 * It no-ops when window.Echo is unavailable, so it's safe to ship unconditionally.
 */
if (typeof window !== 'undefined' && window.Echo) {
    // --- Live chat ---------------------------------------------------------
    // Add data-conversation-id="{{ $conversation->id }}" to your chat container.
    const chat = document.querySelector('[data-conversation-id]')
    if (chat) {
        const id = chat.dataset.conversationId
        window.Echo.private(`conversation.${id}`).listen('NewChatMessage', (e) => {
            // Hand off to your UI; the chat view can listen for this event.
            document.dispatchEvent(new CustomEvent('adminlte:chat-message', { detail: e }))
        })
    }

    // --- Live notifications ------------------------------------------------
    // Laravel broadcasts notifications on the private `App.Models.User.{id}` channel.
    const meta = document.querySelector('meta[name="user-id"]')
    if (meta && meta.content) {
        window.Echo.private(`App.Models.User.${meta.content}`)
            .notification((notification) => {
                document.dispatchEvent(new CustomEvent('adminlte:notification', { detail: notification }))
            })
    }
}
